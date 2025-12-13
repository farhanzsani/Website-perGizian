<!-- Modal -->
<div id="userModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Overlay with blur effect -->
    <div id="modalOverlay" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0" onclick="closeModal()"></div>

    <!-- Modal Container -->
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            
            <!-- Modal Content -->
            <div id="modalPanel" class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl transform transition-all duration-300 ease-out opacity-0 scale-95">
                
                <!-- Header -->
                <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900" id="modalTitle">Tambah User</h3>
                        <p class="text-sm text-gray-500 mt-1">Lengkapi data pengguna di bawah ini.</p>
                    </div>
                    <button type="button" onclick="closeModal()" class="group p-2 rounded-full hover:bg-gray-100 transition">
                        <svg class="h-6 w-6 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form id="userForm" class="p-8">
                    <input type="hidden" id="userId" name="id">
                    
                    <!-- Nama & Email Section -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="name">Nama Lengkap</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <input type="text" id="name" name="name" placeholder="Contoh: Budi Santoso"
                                    class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:border-leaf focus:ring-2 focus:ring-leaf/20 transition shadow-sm">
                            </div>
                            <p class="text-red-500 text-xs mt-2 hidden" id="error-name"></p>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2" for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="nama@email.com"
                                    class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:border-leaf focus:ring-2 focus:ring-leaf/20 transition shadow-sm">
                                <p class="text-red-500 text-xs mt-2 hidden" id="error-email"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2" for="role">Role Pengguna</label>
                                <div class="relative" x-data="{
                                    open: false,
                                    selected: '',
                                    label: 'Pilih Role',
                                    init() {
                                        window.addEventListener('set-role', (e) => {
                                            this.selected = e.detail.value;
                                            this.label = e.detail.label;
                                        });
                                        window.addEventListener('reset-role', () => {
                                            this.selected = '';
                                            this.label = 'Pilih Role';
                                        });
                                    },
                                    select(val, lbl) {
                                        this.selected = val;
                                        this.label = lbl;
                                        this.open = false;
                                        document.getElementById('role').value = val;
                                        
                                        // Clear error style if exists
                                        const btn = document.getElementById('role-button');
                                        if(btn) {
                                            btn.classList.remove('border-red-500', 'ring-red-200');
                                            btn.classList.add('border-gray-200');
                                        }
                                        document.getElementById('error-role').classList.add('hidden');
                                    }
                                }">
                                    <input type="hidden" id="role" name="role">
                                    
                                    <button type="button" id="role-button" @click="open = !open" @click.outside="open = false"
                                        class="flex items-center justify-between w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-leaf/20 hover:border-leaf group">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full transition-colors" :class="selected ? 'bg-leaf' : 'bg-gray-300'"></div>
                                            <span x-text="label" :class="selected ? 'font-medium' : 'text-gray-400'"></span>
                                        </div>
                                        <svg :class="{'rotate-180': open}" class="h-5 w-5 text-gray-400 group-hover:text-leaf transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <!-- Menu Dropdown di Modal -->
                                    <div x-show="open" 
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-2"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-2"
                                        class="absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-100 z-30 overflow-hidden ring-1 ring-black ring-opacity-5">
                                        
                                        <div class="py-1">
                                            @foreach($roles as $role)
                                                <button type="button" @click="select('{{ $role }}', '{{ ucfirst($role) }}')" 
                                                    class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-left hover:bg-mint/30 transition-colors"
                                                    :class="selected === '{{ $role }}' ? 'text-leaf bg-mint/10 font-medium' : 'text-charcoal'">
                                                    <div class="w-1.5 h-1.5 rounded-full" :class="selected === '{{ $role }}' ? 'bg-leaf' : 'bg-transparent'"></div>
                                                    {{ ucfirst($role) }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <p class="text-red-500 text-xs mt-2 hidden" id="error-role"></p>
                            </div>
                        </div>



                        <!-- Password Section -->
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Password Input -->
                            <div class="relative w-full">
                                <input type="password" id="password" name="password" placeholder="Password baru"
                                    onfocus="document.getElementById('password-hint-text').classList.remove('hidden')"
                                    onblur="document.getElementById('password-hint-text').classList.add('hidden')"
                                    class="w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:border-leaf focus:ring-2 focus:ring-leaf/20 transition shadow-sm">
                                
                                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-charcoal transition rounded-r-xl">
                                    <svg id="password-eye" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Confirmation Input -->
                            <div class="relative w-full">
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password"
                                    class="w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:border-leaf focus:ring-2 focus:ring-leaf/20 transition shadow-sm">
                                
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-charcoal transition rounded-r-xl">
                                    <svg id="password_confirmation-eye" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Hints & Errors -->
                        <div class="mt-2 flex items-start justify-between min-h-[20px]">
                            <p class="text-xs text-gray-500 hidden items-center gap-1.5 transition-all" id="password-hint-text">
                                <svg class="h-3 w-3 text-leaf" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Minimal 8 karakter
                            </p>
                            <p class="text-red-500 text-xs hidden ml-auto" id="error-password"></p>
                        </div>
                    </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                        <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-semibold text-slate bg-transparent hover:bg-gray-50 hover:text-charcoal rounded-xl transition-all transform hover:scale-105 active:scale-95">
                            Batal
                        </button>
                        <button type="button" onclick="saveUser()" id="saveBtn" class="px-6 py-2.5 text-sm font-semibold text-white bg-leaf hover:bg-emerald-600 rounded-xl shadow-lg shadow-leaf/30 hover:shadow-leaf/50 transition-all transform hover:scale-105 active:scale-95 focus:ring-2 focus:ring-offset-2 focus:ring-leaf">
                            <span id="saveBtnText">Simpan Data</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />`;
    } else {
        field.type = 'password';
        eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
    }
}
</script>
