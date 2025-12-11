<header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 sticky top-0 z-10">

    <div class="flex items-center">
        <button @click="sidebarOpen = true" class="text-slate focus:outline-none lg:hidden">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>

        <h2 class="text-xl font-bold text-charcoal hidden lg:block ml-2">
            Admin Panel
        </h2>
    </div>

    <div class="flex items-center gap-4">
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2 focus:outline-none">
                <img class="w-8 h-8 rounded-full object-cover border border-gray-200"
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2E9A62&color=fff"
                    alt="Admin Avatar">
                <span class="text-sm font-medium text-charcoal hidden md:block">{{ auth()->user()->name }}</span>
                <i data-lucide="chevron-down" class="w-4 h-4 text-slate"></i>
            </button>

            <div x-show="dropdownOpen" @click.outside="dropdownOpen = false" x-transition
                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 border border-gray-100 z-50"
                style="display: none;">

                <div class="px-4 py-2 border-b border-gray-100">
                    <p class="text-xs text-slate">Role</p>
                    <p class="text-sm font-bold text-leaf">Administrator</p>
                </div>

                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 text-sm text-charcoal hover:bg-eggshell hover:text-leaf">
                    Edit Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-tomato hover:bg-red-50">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
