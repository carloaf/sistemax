<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Movimentacao;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de materiais no estoque
        $totalMateriais = Material::count();
        
        // Valor total do estoque
        $valorTotalEstoque = Material::sum(DB::raw('quantidade * valor_unitario'));
        
        // Materiais em falta (estoque abaixo do mínimo)
        $materiaisEmFalta = Material::whereColumn('quantidade', '<', 'estoque_minimo')->count();
        
        // Movimentações recentes (últimos 30 dias)
        $movimentacoesRecentes = Movimentacao::where('created_at', '>=', now()->subDays(30))->count();
        
        // Últimas 5 movimentações
        $ultimasMovimentacoes = Movimentacao::with('material')
            ->latest()
            ->take(5)
            ->get();
        
        // Dados para o gráfico (últimos 7 dias)
        $movimentacoesData = Movimentacao::select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            ])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total');
            
        $movimentacoesLabels = Movimentacao::select([
                DB::raw('DATE(created_at) as date')
            ])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('d/m');
            });

        return view('dashboard', compact(
            'totalMateriais',
            'valorTotalEstoque',
            'materiaisEmFalta',
            'movimentacoesRecentes',
            'ultimasMovimentacoes',
            'movimentacoesData',
            'movimentacoesLabels'
        ));
    }
}