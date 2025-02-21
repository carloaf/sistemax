<nav class="p-4">
    <!-- Logo -->
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-logo class="block h-8 w-auto" />
            <span class="sidebar-text ml-2">Sistemax</span>
        </a>
    </div>

    <ul class="space-y-2">
        <!-- Dashboard -->
        <li>
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-green-700 rounded-lg hover:bg-green-100 {{ request()->routeIs('dashboard') ? 'bg-gray-100' : '' }}">
                <i class="fas fa-tachometer-alt mr-2"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </li>

        <!-- Submenu Documentos -->
        <li x-data="{ open: false }">
            <a @click="open = !open" class="flex items-center justify-between px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100 cursor-pointer">
                <span class="flex items-center">
                    <i class="fas fa-folder mr-2"></i>
                    <span class="sidebar-text">Documentos</span>
                </span>
                <span :class="open ? 'rotate-90' : ''" class="transform transition-transform duration-200">
                    <i class="fas fa-chevron-right text-sm"></i>
                </span>
            </a>
            <ul x-show="open" class="pl-8 mt-1 space-y-1">
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Fornecimento</a></li>
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Entrada</a></li>
            </ul>
        </li>

        <!-- Submenu Contas -->
        <li x-data="{ open: false }">
            <a @click="open = !open" class="flex items-center justify-between px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100 cursor-pointer">
                <span class="flex items-center">
                    <i class="fas fa-wallet mr-2"></i>
                    <span class="sidebar-text">Contas</span>
                </span>
                <span :class="open ? 'rotate-90' : ''" class="transform transition-transform duration-200">
                    <i class="fas fa-chevron-right text-sm"></i>
                </span>
            </a>
            <ul x-show="open" class="pl-8 mt-1 space-y-1">
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">All Contas</a></li>
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Edit Conta</a></li>
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Add Contas</a></li>
            </ul>
        </li>

        <!-- Submenu Configurações -->
        <li x-data="{ open: false }">
            <a @click="open = !open" class="flex items-center justify-between px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100 cursor-pointer">
                <span class="flex items-center">
                    <i class="fas fa-cog mr-2"></i>
                    <span class="sidebar-text">Configurações</span>
                </span>
                <span :class="open ? 'rotate-90' : ''" class="transform transition-transform duration-200">
                    <i class="fas fa-chevron-right text-sm"></i>
                </span>
            </a>
            <ul x-show="open" class="pl-8 mt-1 space-y-1">
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Config List</a></li>
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Config Add</a></li>
            </ul>
        </li>

        <!-- Submenu Accounts -->
        <li x-data="{ open: false }">
            <a @click="open = !open" class="flex items-center justify-between px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100 cursor-pointer">
                <span class="flex items-center">
                    <i class="far fa-money-bill-alt mr-2"></i>
                    <span class="sidebar-text">Accounts</span>
                </span>
                <span :class="open ? 'rotate-90' : ''" class="transform transition-transform duration-200">
                    <i class="fas fa-chevron-right text-sm"></i>
                </span>
            </a>
            <ul x-show="open" class="pl-8 mt-1 space-y-1">
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Invoices</a></li>
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Payments</a></li>
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Expenses</a></li>
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Taxes</a></li>
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Provident Fund</a></li>
            </ul>
        </li>

        <!-- Submenu Usuário -->
        <li x-data="{ open: false }">
            <a @click="open = !open" class="flex items-center justify-between px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100 cursor-pointer">
                <span class="flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    <span class="sidebar-text">Usuário</span>
                </span>
                <span :class="open ? 'rotate-90' : ''" class="transform transition-transform duration-200">
                    <i class="fas fa-chevron-right text-sm"></i>
                </span>
            </a>
            <ul x-show="open" class="pl-8 mt-1 space-y-1">
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Add User</a></li>
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">All User</a></li>
                <li><a href="#" class="block px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">Edit User</a></li>
            </ul>
        </li>
    </ul>
</nav>