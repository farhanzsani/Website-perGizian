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
            <i data-lucide="user" class="w-5 h-5"></i>
            Kelola Pengguna
        </a>

        <a href="#"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.families*') ? 'bg-leaf text-white shadow-md shadow-green-200' : 'text-slate hover:bg-mint/30 hover:text-leaf' }}">
            <i data-lucide="users" class="w-5 h-5"></i>
            Kelola Keluarga
        </a>

        <a href="{{ route('admin.ahligizi.index') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.ahligizi.*') ? 'bg-leaf text-white shadow-md shadow-green-200' : 'text-slate hover:bg-mint/30 hover:text-leaf' }}">
            <i data-lucide="scan-heart" class="w-5 h-5"></i>
            Kelola Ahli Gizi
        </a>

        <a href="{{ route('admin.pelacakan-makanan.index') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.pelacakan-makanan.*') ? 'bg-leaf text-white shadow-md shadow-green-200' : 'text-slate hover:bg-mint/30 hover:text-leaf' }}">
            <i data-lucide="activity" class="w-5 h-5"></i>
            Pelacakan Makanan
        </a>

        <div x-data="{ open: {{ request()->routeIs('admin.artikel.*') || request()->routeIs('admin.kategori.*') ? 'true' : 'false' }} }">

            <button @click="open = !open" type="button"
                class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium rounded-xl transition-colors text-slate hover:bg-mint/30 hover:text-leaf {{ request()->routeIs('admin.artikel.*') || request()->routeIs('admin.kategori.*') ? 'bg-leaf text-white shadow-md shadow-green-200' : 'text-slate hover:bg-mint/30 hover:text-leaf' }}">

                <div class="flex items-center gap-3">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                    <span>Kelola Artikel</span>
                </div>

                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200"
                    :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                class="mt-1 space-y-1 pl-11" style="display: none;">

                <a href="{{ route('admin.artikel.index') }}"
                    class="block px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.artikel.*') ? 'text-leaf font-bold bg-mint/20' : 'text-slate hover:text-leaf hover:bg-gray-50' }}">
                    Daftar Artikel
                </a>

                {{-- Pastikan route ini ada --}}
                <a href="{{ route('admin.kategori.index') }}"
                    class="block px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.kategori.*') ? 'text-leaf font-bold bg-mint/20' : 'text-slate hover:text-leaf hover:bg-gray-50' }}">
                    Kategori Artikel
                </a>
            </div>
        </div>

        <div x-data="{ open: {{ request()->routeIs('admin.kelolamakanan.*') || request()->routeIs('admin.pengajuan.*') || request()->routeIs('admin.kategorimakanan.*') ? 'true' : 'false' }} }">

            <button @click="open = !open" type="button"
                class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium rounded-xl transition-colors text-slate hover:bg-mint/30 hover:text-leaf {{ request()->routeIs('admin.kelolamakanan.*') || request()->routeIs('admin.pengajuan.*') || request()->routeIs('admin.kategorimakanan.*') ? 'bg-leaf text-white shadow-md shadow-green-200' : 'text-slate hover:bg-mint/30 hover:text-leaf' }}">

                <div class="flex items-center gap-3">
                    <i data-lucide="utensils" class="w-5 h-5"></i>
                    <span>Kelola Data Makanan</span>
                </div>

                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200"
                    :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                class="mt-1 space-y-1 pl-11" style="display: none;">

                <a href="{{ route('admin.kelolamakanan.index') }}"
                    class="block px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.kelolamakanan.*') ? 'text-leaf font-bold bg-mint/20' : 'text-slate hover:text-leaf hover:bg-gray-50' }}">
                    Makanan
                </a>

                <a href="{{ route('admin.kategorimakanan.index') }}"
                    class="block px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.kategorimakanan.*') ? 'text-leaf font-bold bg-mint/20' : 'text-slate hover:text-leaf hover:bg-gray-50' }}">
                    Kategori Makanan
                </a>

                <a href="{{ route('admin.pengajuan.index') }}"
                    class="block px-4 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.pengajuan.*') ? 'text-leaf font-bold bg-mint/20' : 'text-slate hover:text-leaf hover:bg-gray-50' }}">
                    Pengajuan
                </a>
            </div>
        </div>
    </nav>
</aside>
