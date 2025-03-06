@extends('layouts.app')

@section('title', 'Relatório de Estoque Atual')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6 border-b-2 border-blue-500 pb-2">Estoque Atual</h1>

        <!-- Filtros e Busca -->
        <form class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-3">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Buscar por nome, código ou descrição"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex-1">
                        Buscar
                    </button>
                    <a href="{{ route('relatorios.estoque') }}" 
                       class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
                        Limpar
                    </a>
                </div>
            </div>
        </form>

        <!-- Tabela de Estoque -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'code', 'direction' => ($sort === 'code' && $direction === 'asc') ? 'desc' : 'asc']) }}">
                                Código
                                @if($sort === 'code')
                                    @if($direction === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => ($sort === 'name' && $direction === 'asc') ? 'desc' : 'asc']) }}">
                                Material
                                @if($sort === 'name')
                                    @if($direction === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'quantity', 'direction' => ($sort === 'quantity' && $direction === 'asc') ? 'desc' : 'asc']) }}">
                                Estoque
                                @if($sort === 'quantity')
                                    @if($direction === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor Unitário Médio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($materiais as $material)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $material->code ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $material->name }}</div>
                            <div class="text-sm text-gray-500">{{ $material->description }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $material->unit }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 rounded-full 
                                {{ $material->quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ number_format($material->quantity, 2, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            R$ {{ $material->average_unit_price ?
                                number_format($material->average_unit_price, 2, ',', '.') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                            R$ {{ number_format($material->total_value, 2, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Nenhum material encontrado
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação e Resumo -->
        <div class="mt-6 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                {{ $materiais->links() }}
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex gap-4">
                    <div class="text-center">
                        <div class="text-sm text-gray-500">Total de Itens</div>
                        <div class="text-xl font-bold">{{ $materiais->total() }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm text-gray-500">Valor Total Estoque</div>
                        <div class="text-xl font-bold text-green-600">
                            R$ {{ number_format($materiais->sum('total_value'), 2, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection