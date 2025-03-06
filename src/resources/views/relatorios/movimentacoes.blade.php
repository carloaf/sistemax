@extends('layouts.app')

@section('title', 'Relatório de Movimentações')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6 border-b-2 border-blue-500 pb-2">Relatório de Movimentações</h1>

        <!-- Filtros -->
        <form class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Data Início</label>
                    <input type="date" name="data_inicio" value="{{ request('data_inicio') }}" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Data Fim</label>
                    <input type="date" name="data_fim" value="{{ request('data_fim') }}" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo</label>
                    <select name="tipo" class="w-full px-3 py-2 border rounded-lg">
                        <option value="">Todos</option>
                        <option value="entry" {{ request('tipo') == 'entry' ? 'selected' : '' }}>Entrada</option>
                        <option value="exit" {{ request('tipo') == 'exit' ? 'selected' : '' }}>Saída</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex-1">
                        Filtrar
                    </button>
                    <a href="{{ route('relatorios.movimentacoes') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
                        Limpar
                    </a>
                </div>
            </div>
        </form>

        <!-- Tabela -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Material</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Observação</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($movimentacoes as $mov)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $mov->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 rounded-full text-sm 
                                {{ $mov->type == 'entry' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $mov->type == 'entry' ? 'Entrada' : 'Saída' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $mov->material->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $mov->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($mov->documento)
                            <a href="#" class="text-blue-600 hover:underline">
                                {{ $mov->documento->document_number ?? 'N/A' }}
                            </a>
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap max-w-xs truncate">
                            {{ $mov->observation }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Nenhuma movimentação encontrada
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <div class="mt-6">
            {{ $movimentacoes->links() }}
        </div>
    </div>
</div>
@endsection