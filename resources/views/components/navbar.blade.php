<header x-data="{ mobileOpen: false }"
    class="flex flex-wrap md:justify-start md:flex-nowrap bg-white/90 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50 transition-all duration-300">
    <nav
        class="relative max-w-[85rem] w-full mx-auto lg:flex xl:items-center lg:justify-between md:gap-3 py-6 px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center gap-x-1">
            <a class="flex-none font-semibold text-xl focus:outline-none focus:opacity-80 cursor-pointer" href="/">
                <span class="inline-flex items-center gap-x-2 text-2xl font-bold text-leaf">
                    <i data-lucide="leaf" class="w-8 h-8 text-leaf fill-mint"></i>
                    CarePlate
                </span>
            </a>

            <button @click="mobileOpen = !mobileOpen" type="button"
                class="lg:hidden relative size-9 flex justify-center items-center font-medium text-sm rounded-lg border border-gray-200 text-charcoal hover:bg-gray-100 focus:outline-none">
                <i data-lucide="menu" class="w-5 h-5" x-show="!mobileOpen"></i>
                <i data-lucide="x" class="w-5 h-5" x-show="mobileOpen" style="display: none;"></i>
            </button>
        </div>

        <div :class="mobileOpen ? 'block' : 'hidden'"
            class="w-full lg:block md:w-auto lg:basis-full lg:grow transition-all duration-300">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-end gap-2 lg:gap-6 mt-4 lg:mt-0 lg:pl-6">
                @auth
                    @if (Auth::user()->hasRole('admin'))
                        <a href="{{ route('onboarding') }}"
                            class=" {{ request()->routeIs('onboarding') ? 'text-leaf border-b-2 border-leaf' : 'text-slate hover:text-leaf ' }} p-2 font-medium transition-colors">Beranda</a>
                        <a href="{{ route('artikel.index') }}"
                            class="p-2 {{ request()->routeIs('artikel.*') ? 'text-leaf border-b-2 border-leaf' : 'text-slate hover:text-leaf ' }} font-medium transition-colors">Artikel</a>
                    @else
                        <a href="{{ route('onboarding') }}"
                            class=" {{ request()->routeIs('onboarding') ? 'text-leaf border-b-2 border-leaf' : 'text-slate hover:text-leaf ' }} p-2 font-medium transition-colors">Beranda</a>
                        <a href="{{ route('kalkulator.index') }}"
                            class="p-2 {{ request()->routeIs('kalkulator.*') ? 'text-leaf border-b-2 border-leaf' : 'text-slate hover:text-leaf ' }} font-medium transition-colors">Kalkulator</a>
                        <a href="{{ route('onboarding') }}"
                            class="p-2 {{ request()->routeIs('/') ? 'text-leaf border-b-2 border-leaf' : 'text-slate hover:text-leaf ' }} font-medium transition-colors">Keluarga</a>
                        <div class="relative group" x-data="{ open: false }">

                            <button @click="open = !open" @mouseenter="open = true"
                                class="flex items-center gap-1 p-2 font-medium transition-colors cursor-pointer w-full lg:w-auto justify-between lg:justify-start
            ">

                                <span
                                    class="{{ request()->routeIs('makanan.*') ? 'text-leaf border-b-2 border-leaf lg:border-b-0' : 'text-slate hover:text-leaf' }}">Makanan</span>

                                <i data-lucide="chevron-down"
                                    class="w-4 h-4 transition-transform duration-200 lg:group-hover:rotate-180"
                                    :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="open" @mouseleave="open = false" @click.outside="open = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 lg:translate-y-2"
                                x-transition:enter-end="opacity-100 lg:translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 lg:translate-y-0"
                                x-transition:leave-end="opacity-0 lg:translate-y-2"
                                class="lg:absolute lg:left-0 lg:mt-2 lg:w-56 lg:bg-white lg:rounded-xl lg:shadow-xl lg:border lg:border-gray-100 lg:z-50
                w-full pl-4 lg:pl-0 mt-1 space-y-1 lg:space-y-0"
                                style="display: none;">

                                <a href="{{ route('makanan.carikalori.index') }}"
                                    class="block px-4 py-3 text-sm text-charcoal hover:bg-eggshell hover:text-leaf rounded-lg lg:rounded-none transition-colors group/item">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="p-2 bg-mint/20 rounded-lg text-leaf group-hover/item:bg-leaf group-hover/item:text-white transition-colors">
                                            <i data-lucide="search" class="w-4 h-4"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold block">Cari Kalori</span>
                                            <span class="text-xs text-slate font-normal">Database kalori makanan </span>
                                        </div>
                                    </div>
                                </a>

                                <a href="/"
                                    class="block px-4 py-3 text-sm text-charcoal hover:bg-eggshell hover:text-leaf rounded-lg lg:rounded-none transition-colors group/item">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="p-2 bg-mint/20 rounded-lg text-leaf group-hover/item:bg-leaf group-hover/item:text-white transition-colors">
                                            <i data-lucide="alarm-clock" class="w-4 h-4"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold block">Reminder Jadwal</span>
                                            <span class="text-xs text-slate font-normal">Siap Ingetin Jadwal Makan
                                                Kamu</span>
                                        </div>
                                    </div>
                                </a>

                                <a href="/"
                                    class="block px-4 py-3 text-sm text-charcoal hover:bg-eggshell hover:text-leaf rounded-lg lg:rounded-none transition-colors group/item">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="p-2 bg-mint/20 rounded-lg text-leaf group-hover/item:bg-leaf group-hover/item:text-white transition-colors">
                                            <i data-lucide="utensils-crossed" class="w-4 h-4"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold block">Tracking Kalori</span>
                                            <span class="text-xs text-slate font-normal">Tracking Makanan Yang Sudah
                                                dikonsumsi</span>
                                        </div>
                                    </div>
                                </a>




                                <a href="/"
                                    class="block px-4 py-3 text-sm text-charcoal hover:bg-eggshell hover:text-leaf rounded-lg lg:rounded-none transition-colors group/item">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="p-2 bg-mint/20 rounded-lg text-leaf group-hover/item:bg-leaf group-hover/item:text-white transition-colors">
                                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold block">Ajukan Makanan</span>
                                            <span class="text-xs text-slate font-normal">Kontribusi data baru</span>
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </div>
                        <a href="{{ route('artikel.index') }}"
                            class="p-2 {{ request()->routeIs('artikel.*') ? 'text-leaf border-b-2 border-leaf' : 'text-slate hover:text-leaf ' }} font-medium transition-colors">Artikel</a>
                    @endif
                @else
                    <a href="/#home" class="p-2 text-slate hover:text-leaf font-medium transition-colors">Beranda</a>
                    <a href="/#about" class="p-2 text-slate hover:text-leaf font-medium transition-colors">Tentang</a>
                    <a href="/#features" class="p-2 text-slate hover:text-leaf font-medium transition-colors">Fitur</a>
                    <a href="/#consultation"
                        class="p-2 text-slate hover:text-leaf font-medium transition-colors">Konsultasi</a>
                    <a href="{{ route('artikel.index') }}"
                        class="p-2 {{ request()->routeIs('artikel.*') ? 'text-leaf border-b-2 border-leaf' : 'text-slate hover:text-leaf ' }} font-medium transition-colors">Artikel</a>
                @endauth

                <div class="hidden xl:block w-px h-6 bg-gray-200 mx-2"></div>

                <div class="flex flex-col md:flex-row gap-3">
                    @auth
                        <div class="relative" x-data="{ dropdownOpen: false }">

                            <button @click="dropdownOpen = !dropdownOpen" type="button"
                                class="flex items-center gap-x-2 text-sm font-semibold rounded-full border border-gray-200 bg-white text-charcoal shadow-sm hover:bg-gray-50 py-1 pl-1 pr-3 w-full md:w-auto">
                                <img class="inline-block size-[32px] rounded-full ring-2 ring-white"
                                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=CFF4E1&color=2E9A62"
                                    alt="Avatar">
                                <span
                                    class="truncate max-w-[100px] sm:max-w-none overflow-hidden">{{ auth()->user()->name }}</span>
                                <i data-lucide="chevron-down" class="size-4 transition-transform duration-200"
                                    :class="dropdownOpen ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="dropdownOpen" @click.outside="dropdownOpen = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 z-50 mt-2 w-56 origin-top-right rounded-xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                style="display: none;">

                                <div class="py-1">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-xs text-slate">Signed in as</p>
                                        <p class="text-sm font-bold text-charcoal truncate">{{ auth()->user()->email }}
                                        </p>
                                    </div>
                                    @if (Auth::user()->hasRole('admin'))
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="flex items-center gap-2 px-4 py-2 text-sm text-charcoal hover:bg-eggshell">
                                            <i data-lucide="layout-dashboard" class="size-4 text-leaf"></i> Dashboard
                                        </a>
                                        <a href="{{ route('profile.index') }}"
                                            class="flex items-center gap-2 px-4 py-2 text-sm text-charcoal hover:bg-eggshell">
                                            <i data-lucide="user" class="size-4 text-leaf"></i> Profile
                                        </a>
                                    @else
                                        <a href="{{ route('profile.index') }}"
                                            class="flex items-center gap-2 px-4 py-2 text-sm text-charcoal hover:bg-eggshell">
                                            <i data-lucide="user" class="size-4 text-leaf"></i> Profile
                                        </a>
                                    @endif

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex w-full items-center gap-2 px-4 py-2 text-sm text-tomato hover:bg-red-50">
                                            <i data-lucide="log-out" class="size-4"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login') }}"
                                class="py-2 px-5 inline-flex items-center font-semibold text-sm rounded-full bg-coral text-white hover:bg-orange-600 transition-all shadow-md hover:shadow-lg">
                                Masuk
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>
