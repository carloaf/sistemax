@extends('layouts.app')

@section('title', 'Histórico de Movimentações - ' . $material->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <!-- Cabeçalho -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold border-b-2 border-blue-500 pb-2">
                    <i class="fas fa-history mr-2"></i>
                    Histórico de Movimentações: {{ $material->name }}
                </h1>
                <div class="mt-2 text-sm text-gray-600">
                    <span class="font-medium">Código:</span> {{ $material->code }} | 
                    <span class="font-medium">Estoque Atual:</span> 
                    <span class="{{ $material->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($material->quantity, 2, ',', '.') }} {{ $material->unit }}
                    </span>
                </div>
            </div>
            <a href="{{ route('relatorios.estoque') }}" 
               class="text-blue-600 hover:text-blue-800 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Voltar ao Estoque
            </a>
        </div>

        <!-- Tabela de Movimentações -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Observações</th>
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
                            {{ number_format($mov->quantity, 2, ',', '.') }} {{ $material->unit }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($mov->document)
                            <a href="#" class="text-blue-600 hover:underline">
                                {{ $mov->document->document_number }}
                            </a>
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <div class="truncate hover:whitespace-normal">
                                {{ $mov->observation }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Nenhuma movimentação registrada
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação e Resumo -->
        <div class="mt-6 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                {{ $movimentacoes->links() }}
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex gap-4">
                    <div class="text-center">
                        <div class="text-sm text-gray-500">Total de Entradas</div>
                        <div class="text-xl font-bold text-green-600">
                            +{{ number_format($material->movements()->where('type', 'entry')->sum('quantity'), 2, ',', '.') }}
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm text-gray-500">Total de Saídas</div>
                        <div class="text-xl font-bold text-red-600">
                            -{{ number_format($material->movements()->where('type', 'exit')->sum('quantity'), 2, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection