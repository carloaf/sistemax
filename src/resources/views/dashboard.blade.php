@extends('layouts.app')

@section('title', 'Dashboard - Controle de Estoque')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Cabeçalho -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-2">Resumo do controle de estoque</p>
    </div>

    <!-- Cards de Métricas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total de Materiais -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-100 rounded-full mr-4">
                    <i class="fas fa-boxes text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500">Total de Materiais</p>
                    <p class="text-2xl font-bold">{{ $totalMaterials }}</p>
                </div>
            </div>
        </div>

        <!-- Valor Total do Estoque -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-100 rounded-full mr-4">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500">Valor Total do Estoque</p>
                    <p class="text-2xl font-bold">R$ {{ number_format($totalStockValue, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Materiais abaixo do estoque minimo -->
        <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center gap-4">
                <div class="p-3 bg-red-100 rounded-full mr-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500">Materiais abaixo do estoque minimo</p>
                    <p class="text-2xl font-bold">{{ $lowStockMaterials }}</p>
                </div>
            </div>
        </div>

        <!-- Movimentações Recentes -->
        <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center gap-4">
                <div class="p-3 bg-purple-100 rounded-full mr-4">
                    <i class="fas fa-exchange-alt text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500">Movimentações (7 dias)</p>
                    <p class="text-2xl font-bold">{{ $movementData->sum() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico e Tabela -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gráfico de Movimentações -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Movimentações Recentes</h3>
            <div class="h-64">
                <canvas id="movementChart"></canvas>
            </div>
        </div>

        <!-- Últimas Movimentações -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Últimas Movimentações</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="pb-3">Material</th>
                            <th class="pb-3">Tipo</th>
                            <th class="pb-3">Quantidade</th>
                            <th class="pb-3">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestMovements as $movement)
                        <tr class="border-b">
                            <td class="py-3">{{ $movement->material->name }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 rounded-full text-sm 
                                    {{ $movement->type === 'entry' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $movement->type === 'entry' ? 'Entrada' : 'Saída' }}
                                </span>
                            </td>
                            <td class="py-3">{{ $movement->quantity }}</td>
                            <td class="py-3">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Script para o gráfico (Chart.js) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('movementChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($movementLabels) !!},
            datasets: [{
                label: 'Movimentações por Dia',
                data: {!! json_encode($movementData) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: '#3b82f6',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection