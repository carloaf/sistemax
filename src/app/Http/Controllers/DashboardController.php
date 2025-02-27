<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Movement;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMaterials = Material::count(); // Certifique-se de que esta linha existe
        // dd($totalMaterials);
        $totalStockValue = Material::sum(DB::raw('quantity * unit_price'));
        $lowStockMaterials = Material::whereColumn('quantity', '<', 'minimum_stock')->count();
        $latestMovements = Movement::with('material')->latest()->take(5)->get();

        // Dados para gráfico (movimentações nos últimos 7 dias)
        $movementData = Movement::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count');

        $movementLabels = Movement::selectRaw('DATE(created_at) as date')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('date')
            ->map(fn ($date) => \Carbon\Carbon::parse($date)->format('d/m'));

        return view('dashboard', compact(
            'totalMaterials', // Certifique-se de que está listada aqui
            'totalStockValue',
            'lowStockMaterials',
            'latestMovements',
            'movementData',
            'movementLabels'
        ));
    }
}
