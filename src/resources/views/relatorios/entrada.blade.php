@extends('layouts.app')

@section('title', 'Relatório de Entrada de Materiais')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6 border-b-2 border-blue-500 pb-2">Relatório de Entrada de Materiais</h1>

        <!-- Filtros -->
        <form class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Data Início</label>
                    <input type="date" name="data_inicio" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Data Fim</label>
                    <input type="date" name="data_fim" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 text-gray-500 px-4 py-2 rounded-lg hover:bg-blue-600">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>

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

        <!-- Paginação -->
        <div class="mt-6">
            {{ $entradas->links() }}
        </div>
    </div>
</div>
@endsection