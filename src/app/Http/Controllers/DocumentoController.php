<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\Material;
use App\Models\Movement;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    public function create()
    {
        // Lista de materiais para o dropdown
        $materiais = Material::all();
        return view('documentos.entrada', compact('materiais'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'document_number' => 'required|unique:documents,document_number',
            'issue_date' => 'required|date',
            'supplier' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.material_id' => 'required|exists:materials,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0'
        ]);

        // Criar Documento
        $document = Document::create([
            'document_number' => $validated['document_number'],
            'issue_date' => $validated['issue_date'],
            'supplier' => $validated['supplier'],
            'comments' => $request->input('comments', '') // Valor padrão para evitar null
        ]);

        // Processar Itens
        foreach ($validated['items'] as $item) {
            // Salvar Item
            DocumentItem::create([
                'document_id' => $document->id,
                'material_id' => $item['material_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price']
            ]);

            // Atualizar Estoque
            Material::find($item['material_id'])->increment('quantity', $item['quantity']);

            // Criar Movimentação (DENTRO DO LOOP)
            Movement::create([
                'material_id' => $item['material_id'],
                'type' => 'entry',
                'quantity' => $item['quantity'],
                'observation' => 'Entrada via nota fiscal ' . $document->document_number // Observação padrão
            ]);
        }

        return redirect()->route('documentos.entrada')->with('success', 'Nota fiscal registrada!');
    }

    public function fornecimento()
    {
        $materiais = Material::where('quantity', '>', 0)
            ->with(['documentItems' => function($query) {
                $query->oldest();
            }])
            ->get()
            ->map(function($material) {
                $material->oldest_price = $material->documentItems->first()->unit_price ?? 0;
                return $material;
            });

        return view('documentos.fornecimento', compact('materiais'));
    }

    public function storeFornecimento(Request $request)
    {
        $validated = $request->validate([
            'document_number' => 'required|unique:documents,document_number',
            'issue_date' => 'required|date',
            'recipient' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.material_id' => [
                'required',
                'exists:materials,id',
                // Validação personalizada para estoque
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1];
                    $quantity = $request->input("items.{$index}.quantity");
                    $material = Material::find($value);
                    
                    if (!$material) {
                        $fail('Material não encontrado.');
                        return;
                    }
                    
                    if ($material->quantity < $quantity) {
                        $fail("Estoque insuficiente para {$material->name}. Disponível: {$material->quantity}");
                    }
                }
            ],
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {
            // Cria o documento de saída
            $document = Document::create([
                'document_number' => $validated['document_number'],
                'issue_date' => $validated['issue_date'],
                'type' => 'exit',
                'recipient' => $validated['recipient']
            ]);

            foreach ($validated['items'] as $item) {
                $material = Material::findOrFail($item['material_id']);

                // Cria o item do documento
                DocumentItem::create([
                    'document_id' => $document->id,
                    'material_id' => $item['material_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price']
                ]);

                // Atualiza o estoque
                $material->decrement('quantity', $item['quantity']);

                // Registra a movimentação
                Movement::create([
                    'material_id' => $item['material_id'],
                    'document_id' => $document->id,
                    'type' => 'exit',
                    'quantity' => $item['quantity'],
                    'observation' => 'Saída para ' . $validated['recipient']
                ]);
            }

            DB::commit();

            return redirect()->route('documentos.fornecimento')
                ->with('success', 'Documento de fornecimento registrado com sucesso!');

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withErrors('Material não encontrado: ' . $e->getMessage());
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Erro ao processar: ' . $e->getMessage());
        }
    }

}
