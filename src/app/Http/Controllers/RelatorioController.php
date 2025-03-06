<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Movement;
use App\Models\Material;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function entrada(Request $request)
    {
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        $entradas = Document::with(['items.material'])
            ->when($dataInicio && $dataFim, function ($query) use ($dataInicio, $dataFim) {
                return $query->whereBetween('issue_date', [$dataInicio, $dataFim]);
            })
            ->orderBy('issue_date', 'desc')
            ->paginate(15);

        return view('relatorios.entrada', compact('entradas'));
    }

    public function movimentacoes(Request $request)
    {
        $movimentacoes = Movement::with(['material', 'document'])
            ->when($request->data_inicio && $request->data_fim, function ($query) use ($request) {
                return $query->whereBetween('created_at', [$request->data_inicio, $request->data_fim]);
            })
            ->when($request->tipo, function ($query) use ($request) {
                return $query->where('type', $request->tipo);
            })
            ->orderByDesc('created_at')
            ->paginate(15) // Garanta que está usando paginate() e não get()
            ->withQueryString(); // Mantém os parâmetros da URL
    
        return view('relatorios.movimentacoes', compact('movimentacoes'));
    }

    public function estoque(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');
    
        $materiais = Material::query()
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy($sort, $direction)
            ->paginate(15)
            ->withQueryString();
    
        return view('relatorios.estoque', [
            'materiais' => $materiais,
            'sort' => $sort,
            'direction' => $direction
        ]);
    }
}
