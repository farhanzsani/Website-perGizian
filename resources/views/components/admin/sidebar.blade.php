<div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition-transform duration-300 transform bg-white border-r border-gray-200 lg:translate-x-0 lg:static lg:inset-0">

    <div class="flex items-center justify-center h-16 bg-white border-b border-gray-100">
        <span class="flex items-center gap-2 text-2xl font-extrabold text-leaf">
            <i data-lucide="leaf" class="w-8 h-8 fill-mint"></i>
            CarePlate
        </span>
    </div>

    <nav class="mt-5 px-4 space-y-2">

        <p class="px-4 text-xs font-semibold text-slate uppercase tracking-wider mb-2">Menu Utama</p>

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.dashboard') ? 'bg-leaf text-white shadow-md shadow-green-200' : 'text-slate hover:bg-mint/30 hover:text-leaf' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            Dashboard
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.users*') ? 'bg-leaf text-white shadow-md shadow-green-200' : 'text-slate hover:bg-mint/30 hover:text-leaf' }}">
            <i data-lucide="users" class="w-5 h-5"></i>
            Data Pengguna
        </a>

        <a href="#"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.articles*') ? 'bg-leaf text-white shadow-md shadow-green-200' : 'text-slate hover:bg-mint/30 hover:text-leaf' }}">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            Kelola Artikel
        </a>



        <a href="#"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.submissions*') ? 'bg-leaf text-white shadow-md shadow-green-200' : 'text-slate hover:bg-mint/30 hover:text-leaf' }}">
            <i data-lucide="utensils" class="w-5 h-5"></i>
            Kelola Data Makanan
        </a>

        <a href="#"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.submissions*') ? 'bg-leaf text-white shadow-md shadow-green-200' : 'text-slate hover:bg-mint/30 hover:text-leaf' }}">
            <i data-lucide="check-check" class="w-5 h-5"></i>
            Kelola Pengajuan
        </a>

    </nav>
</aside>
