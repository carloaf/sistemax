@extends('layouts.app')

@section('title', 'Entrada de Documento')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-blue-500 pb-3">Registrar Entrada</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('documentos.entrada.store') }}" method="POST" id="documentForm">
            @csrf

            <!-- Linha Superior - Campos Principais -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <!-- Número da Nota -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número da Nota</label>
                    <input type="text" name="document_number" required
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Ex: NF-123456">
                </div>

                <!-- Data de Emissão -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data de Emissão</label>
                    <input type="date" name="issue_date" required
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Fornecedor -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fornecedor</label>
                    <input type="text" name="supplier" required
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Seção de Itens -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Itens da Nota</h3>
                    <button type="button" onclick="addItem()"
                        class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 font-medium px-4 py-2 rounded-lg transition-colors">
                        + Adicionar Item
                    </button>
                </div>

                <div id="itemsContainer" class="space-y-4">
                    <!-- Item Inicial -->
                    <div class="item mb-4 p-4 border rounded-xl bg-gray-50">
                        <div class="grid grid-cols-12 gap-4 items-center">
                            <!-- Material -->
                            <div class="col-span-12 md:col-span-5">
                                <select name="items[0][material_id]" required
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="">Selecione o Material</option>
                                    @foreach ($materiais as $material)
                                        <option value="{{ $material->id }}">{{ $material->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Quantidade -->
                            <div class="col-span-6 md:col-span-2">
                                <input type="number" name="items[0][quantity]" min="1" required
                                    class="w-full px-3 py-2 border rounded-lg" placeholder="Qtd.">
                            </div>

                            <!-- Preço Unitário -->
                            <div class="col-span-6 md:col-span-3">
                                <input type="number" step="0.01" name="items[0][unit_price]" required
                                    class="w-full px-3 py-2 border rounded-lg" placeholder="Preço Unitário">
                            </div>

                            <!-- Botão Remover -->
                            <div class="col-span-12 md:col-span-2 flex justify-center">
                                <button type="button" onclick="removeItem(this)"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                                    Remover
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Observações -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                <textarea name="comments" rows="3"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <!-- Botão de Submissão -->
            <div class="flex justify-end">
                <button type="submit"
                    class="text-blue-600 hover:text-blue-800 font-semibold px-6 py-3 rounded-lg transition-colors border border-blue-600 hover:border-blue-800">
                    Registrar Entrada
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Inicializa o contador com base no número de itens existentes
    let itemCount = document.querySelectorAll('#itemsContainer .item').length;

    function addItem() {
        const itemsContainer = document.getElementById('itemsContainer');
        
        // Cria o novo item com índice único
        const newItem = document.createElement('div');
        newItem.className = 'item mb-4 p-4 border rounded-xl bg-gray-50';
        newItem.innerHTML = `
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-5">
                    <select name="items[${itemCount}][material_id]" required
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecione o Material</option>
                        @foreach ($materiais as $material)
                            <option value="{{ $material->id }}">{{ $material->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6 md:col-span-2">
                    <input type="number" name="items[${itemCount}][quantity]" min="1" required
                        class="w-full px-3 py-2 border rounded-lg" placeholder="Qtd.">
                </div>
                <div class="col-span-6 md:col-span-3">
                    <input type="number" step="0.01" name="items[${itemCount}][unit_price]" required
                        class="w-full px-3 py-2 border rounded-lg" placeholder="Preço Unitário">
                </div>
                <div class="col-span-12 md:col-span-2 flex items-center">
                    <button type="button" onclick="removeItem(this)"
                        class="w-auto bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-colors mx-auto">
                        Remover
                    </button>
                </div>
            </div>
        `;

        // Adiciona o novo item ao container
        itemsContainer.appendChild(newItem);
        itemCount++; // Incrementa após adicionar
    }

    function removeItem(button) {
        const itemToRemove = button.closest('.item');
        itemToRemove.remove();
        
        // Reorganiza os índices após remover um item
        reorganizeIndexes();
    }

    // Função para reindexar os itens após remoção
    function reorganizeIndexes() {
        const items = document.querySelectorAll('#itemsContainer .item');
        itemCount = 0; // Reseta o contador

        items.forEach((item, index) => {
            // Atualiza os atributos 'name' dos campos
            const materialSelect = item.querySelector('[name^="items["]');
            const quantityInput = item.querySelector('[name^="items["][name$="[quantity]"]');
            const priceInput = item.querySelector('[name^="items["][name$="[unit_price]"]');

            // Atualiza os índices para a sequência correta (0, 1, 2...)
            materialSelect.name = `items[${index}][material_id]`;
            quantityInput.name = `items[${index}][quantity]`;
            priceInput.name = `items[${index}][unit_price]`;

            itemCount = index + 1; // Atualiza o contador para o próximo índice
        });
    }
</script>
@endsection