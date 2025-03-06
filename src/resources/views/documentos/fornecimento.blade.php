@extends('layouts.app')

@section('title', 'Fornecimento de Materiais')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-red-500 pb-3">
            <i class="fas fa-truck-moving mr-2"></i>Fornecimento de Materiais
        </h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('documentos.fornecimento.store') }}" method="POST" id="fornecimentoForm">
            @csrf

            <!-- Dados do Fornecimento -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Número do Documento</label>
                    <input type="text" name="document_number" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                        placeholder="EX: NF-00012345">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Data de Emissão</label>
                    <input type="date" name="issue_date" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Destinatário</label>
                    <input type="text" name="recipient" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                        placeholder="Nome do destinatário">
                </div>
            </div>

            <!-- Itens do Fornecimento -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Itens Fornecidos</h3>
                    <button type="button" onclick="addItem()"
                            class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 font-medium px-4 py-2 rounded-lg transition-colors">
                            + Adicionar Item
                        </button>
                </div>

                <div id="itemsContainer" class="space-y-4">
                    <!-- Item Inicial -->
                    <div class="item mb-4 p-4 border rounded-xl bg-red-50">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-5">
                                <select name="items[0][material_id]" required
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                                    onchange="updateMaxQuantity(this)">
                                    <option value="">Selecione o Material</option>
                                    @foreach ($materiais as $material)
                                        <option value="{{ $material->id }}" 
                                            data-quantity="{{ $material->quantity }}">
                                            {{ $material->name }} (Estoque: {{ $material->quantity }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6 md:col-span-2">
                                <input type="number" name="items[0][quantity]" min="1" required
                                    class="w-full px-3 py-2 border rounded-lg" 
                                    placeholder="Qtd."
                                    max="">
                            </div>
                            <div class="col-span-6 md:col-span-3">
                                <input type="number" step="0.01" name="items[0][unit_price]" required
                                    class="w-full px-3 py-2 border rounded-lg" 
                                    placeholder="Preço Unitário">
                            </div>
                            <div class="col-span-12 md:col-span-2 flex items-center">
                                <button type="button" onclick="removeItem(this)"
                                    class="w-full bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg transition-colors">
                                    Remover
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botão de Submissão -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg transition-colors font-semibold">
                    <i class="fas fa-check-circle mr-2"></i>Registrar Fornecimento
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let itemCount = 1;
    
    function addItem() {
        const newItem = document.createElement('div');
        newItem.className = 'item mb-4 p-4 border rounded-xl bg-red-50';
        newItem.innerHTML = `
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-5">
                    <select name="items[${itemCount}][material_id]" required
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                        onchange="updateMaxQuantity(this)">
                        <option value="">Selecione o Material</option>
                        @foreach ($materiais as $material)
                            <option value="{{ $material->id }}" 
                                data-quantity="{{ $material->quantity }}">
                                {{ $material->name }} (Estoque: {{ $material->quantity }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6 md:col-span-2">
                    <input type="number" name="items[${itemCount}][quantity]" min="1" required
                        class="w-full px-3 py-2 border rounded-lg" 
                        placeholder="Qtd."
                        max="">
                </div>
                <div class="col-span-6 md:col-span-3">
                    <input type="number" step="0.01" name="items[${itemCount}][unit_price]" required
                        class="w-full px-3 py-2 border rounded-lg" 
                        placeholder="Preço Unitário">
                </div>
                <div class="col-span-12 md:col-span-2 flex items-center">
                    <button type="button" onclick="removeItem(this)"
                        class="w-full bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg transition-colors">
                        Remover
                    </button>
                </div>
            </div>
        `;
        document.getElementById('itemsContainer').appendChild(newItem);
        itemCount++;
    }

    function removeItem(button) {
        button.closest('.item').remove();
    }

    function updateMaxQuantity(select) {
        const quantityInput = select.closest('.grid').querySelector('input[type="number"]');
        const selectedOption = select.options[select.selectedIndex];
        quantityInput.max = selectedOption.getAttribute('data-quantity');
    }

    // Adicione este evento aos selects
    function updatePrice(selectElement) {
        const materialId = selectElement.value;
        const container = selectElement.closest('.grid');
        const priceInput = container.querySelector('input[name*="unit_price"]');
        
        // Busca o preço mais antigo dos dados pré-carregados
        const material = @json($materiais->keyBy('id'));
        priceInput.value = material[materialId]?.oldest_price || '';
        
        // Ou via AJAX para dados dinâmicos
        /*
        fetch(`/api/material/${materialId}/oldest-price`)
            .then(response => response.json())
            .then(data => {
                priceInput.value = data.price || '';
            });
        */
    }

    // Adicione este evento aos selects
    document.querySelectorAll('select[name*="material_id"]').forEach(select => {
        select.addEventListener('change', function() {
            updatePrice(this);
        });
    });

</script>
@endsection