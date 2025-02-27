<?php

namespace App\Http\Controllers;

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
}
