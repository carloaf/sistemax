<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistemax') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Estilos personalizados -->
    <style>
        .sidebar {
            width: 16rem; /* Largura do sidebar */
            height: 100vh; /* Altura total da tela */
            position: fixed;
            top: 0;
            left: 0;
            z-index: 40;
            overflow-y: auto;
            transition: width 0.3s ease, transform 0.3s ease;
            background-color: #ffffff; /* Cor de fundo do sidebar */
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1); /* Sombra à direita */
        }

        /* Espaçamento para o conteúdo abaixo do header */
        .main-content {
            margin-top: 4rem; /* Altura do header */
        }
        
        .sidebar.collapsed {
            width: 4rem; /* Largura reduzida para exibir apenas ícones */
        }

        .submenu {
            padding-left: 35px; /* Padding para submenus */
        }

        .sidebar.collapsed .sidebar-text {
            display: none; /* Oculta o texto quando o sidebar está recolhido */
        }

        .main-content {
            margin-left: 16rem; /* Largura do sidebar */
            transition: margin-left 0.3s ease;
        }

        .main-content.collapsed {
            margin-left: 4rem; /* Ajusta o margin-left quando o sidebar está recolhido */
        }

        .header {
            position: fixed;
            top: 0;
            right: 0;
            left: 16rem; /* Largura do sidebar */
            z-index: 30;
            height: 4rem; /* Altura do header */
            background-color: #ffffff; /* Cor de fundo do header */
            border-bottom: 1px solid #e5e7eb; /* Borda inferior */
            padding: 0 1rem; /* Espaçamento interno */
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: left 0.3s ease;
        }

        .header.collapsed {
            left: 4rem; /* Ajusta o left quando o sidebar está recolhido */
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%); /* Esconde o sidebar */
            }

            .main-content {
                margin-left: 0; /* Remove o margin-left */
            }

            .header {
                left: 0; /* Header ocupa toda a largura */
            }

            /* Classe para abrir o sidebar */
            .sidebar-open .sidebar {
                transform: translateX(0); /* Mostra o sidebar */
            }

            .sidebar-open .main-content {
                margin-left: 16rem; /* Desloca o conteúdo */
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        @include('layouts.sidebar')
    </aside>

    <!-- Conteúdo Principal -->
    <div class="main-content mt-16" id="main-content">
        <!-- Header -->
        <header class="header" id="header">
            <!-- Botão de toggle para recolher/expandir o sidebar -->
            <button onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Outros elementos do header -->
            <div class="flex items-center">
                <!-- Conteúdo do header (ex: dropdown do usuário) -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </header>

        <!-- Conteúdo da Página -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>

    <!-- Script para controle da sidebar -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const header = document.getElementById('header');

            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
            header.classList.toggle('collapsed');
        }
    </script>
</body>
</html>