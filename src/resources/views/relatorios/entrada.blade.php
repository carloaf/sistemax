@extends('layouts.app')

@section('title', 'Relatório de Entrada de Materiais')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6 border-b-2 border-blue-500 pb-2">Relatório de Entrada de Materiais</h1>

        <!-- Filtros -->
        <form action="{{ route('relatorios.entrada') }}" method="GET" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Data Início</label>
                    <input type="date" name="data_inicio" class="w-full px-3 py-2 border rounded-lg" value="{{ request('data_inicio') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Data Fim</label>
                    <input type="date" name="data_fim" class="w-full px-3 py-2 border rounded-lg" value="{{ request('data_fim') }}">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Filtrar
                    </button>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Registros de Entrada</h3>
                    <div class="flex gap-2">
                        {{-- resources/views/relatorios/entrada.blade.php --}}
                        <form action="{{ route('relatorios.entrada.pdf') }}" method="GET" target="_blank" id="pdfForm">
                            <input type="hidden" name="data_inicio" value="{{ request('data_inicio', now()->subMonth()->format('Y-m-d')) }}">
                            <input type="hidden" name="data_fim" value="{{ request('data_fim', now()->format('Y-m-d')) }}">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
                            </button>
                        </form>
                        <button onclick="window.print()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-print mr-2"></i>Imprimir
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <!-- Botões Separados (Exportar PDF e Imprimir) -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Registros de Entrada</h3>
            <div class="flex gap-2">
                <form action="{{ route('relatorios.entrada.pdf') }}" method="GET" target="_blank">
                    <input type="hidden" name="data_inicio" value="{{ request('data_inicio', now()->subMonth()->format('Y-m-d')) }}">
                    <input type="hidden" name="data_fim" value="{{ request('data_fim', now()->format('Y-m-d')) }}">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
                    </button>
                </form>
                <button onclick="window.print()" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-print mr-2"></i>Imprimir
                </button>
            </div>
        </div>

        <!-- Tabela -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nota Fiscal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Material</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fornecedor</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($entradas as $entrada)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $entrada->document_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($entrada->issue_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach($entrada->items as $item)
                                {{ $item->material->name }}<br>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach($entrada->items as $item)
                                {{ $item->quantity }}<br>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $entrada->supplier }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- resources/views/partials/errors.blade.php --}}
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Paginação -->
        <div class="mt-6">
            {{ $entradas->links() }}
        </div>
    </div>
</div>
@endsection