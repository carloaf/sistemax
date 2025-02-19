@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Cabeçalho do Dashboard -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Bem-vindo, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600 mt-2">Aqui está um resumo das atividades do sistema</p>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full mr-4">
                    <i class="fas fa-file-invoice-dollar text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500">Documentos Totais</p>
                    <p class="text-2xl font-bold">1,234</p>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full mr-4">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500">Concluídos</p>
                    <p class="text-2xl font-bold">890</p>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full mr-4">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500">Pendentes</p>
                    <p class="text-2xl font-bold">284</p>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full mr-4">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500">Usuários Ativos</p>
                    <p class="text-2xl font-bold">56</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico e Tabela -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gráfico -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Atividade Recente</h3>
            <div class="h-64">
                <!-- Espaço para gráfico (ex: Chart.js ou Livewire) -->
                <div class="bg-gray-50 rounded-lg w-full h-full flex items-center justify-center text-gray-400">
                    Área do Gráfico
                </div>
            </div>
        </div>

        <!-- Últimas Atividades -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Últimas Atividades</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="pb-3">Usuário</th>
                            <th class="pb-3">Ação</th>
                            <th class="pb-3">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Exemplo de dados -->
                        <tr class="border-b">
                            <td class="py-3">João Silva</td>
                            <td>Upload de documento</td>
                            <td>10/08/2023</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3">Maria Souza</td>
                            <td>Atualização de conta</td>
                            <td>09/08/2023</td>
                        </tr>
                        <tr>
                            <td class="py-3">Carlos Oliveira</td>
                            <td>Novo fornecedor</td>
                            <td>08/08/2023</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection