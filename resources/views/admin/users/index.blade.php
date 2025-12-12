@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <style>
        @keyframes subtle-bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        .animate-error-bounce {
            animation: subtle-bounce 0.4s cubic-bezier(0.18, 0.89, 0.32, 1.28) both;
        }
    </style>
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-charcoal">Manajemen Pengguna</h2>
                <p class="text-slate text-sm mt-1">Kelola semua pengguna aplikasi CarePlate</p>
            </div>
            <button onclick="openModal()" class="inline-flex items-center gap-2 bg-leaf hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl transition shadow-sm shadow-leaf/25 font-medium text-sm">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah User
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-mint">
                <svg class="h-6 w-6 text-leaf" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-charcoal" id="totalUsers">-</p>
                <p class="text-xs text-slate">Total Pengguna</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50">
                <svg class="h-6 w-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-charcoal" id="totalAdmins">-</p>
                <p class="text-xs text-slate">Admin</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50">
                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-charcoal" id="totalRegularUsers">-</p>
                <p class="text-xs text-slate">User Biasa</p>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="h-5 w-5 text-leaf" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span class="font-medium text-charcoal">Daftar Pengguna</span>
            </div>
            <div class="flex items-center gap-3">
                <!-- Custom Role Filter Dropdown -->
                <div class="relative" x-data="{ 
                    open: false, 
                    selected: '', 
                    label: 'Semua Role',
                    select(val, lbl) {
                        this.selected = val;
                        this.label = lbl;
                        this.open = false;
                        // Update hidden input manually to ensure sync
                        document.getElementById('roleFilter').value = val;
                        fetchUsers(); // Trigger fetch
                    }
                }">
                    <!-- Hidden Input buat dibaca fetchUsers wkwk -->
                    <input type="hidden" id="roleFilter" value="">

                    <!-- Tombol buat munculin dropdown -->
                    <button @click="open = !open" @click.outside="open = false" 
                        class="flex items-center gap-6 pl-4 pr-3 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-medium text-charcoal hover:border-leaf hover:ring-2 hover:ring-leaf/20 transition-all shadow-sm group min-w-[160px] justify-between">
                        <span x-text="label" class="truncate"></span>
                        <svg :class="{'rotate-180': open}" class="h-4 w-4 text-slate group-hover:text-leaf transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Menu Dropdown nya -->
                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute top-full right-0 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-100 z-30 overflow-hidden ring-1 ring-black ring-opacity-5">
                        <div class="py-1">
                            <!-- ... content ... -->
                        </div>
                    </div>
                            <button @click="select('', 'Semua Role')" class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-left hover:bg-mint/30 transition-colors" :class="selected === '' ? 'text-leaf bg-mint/10 font-medium' : 'text-slate'">
                                <div class="w-1.5 h-1.5 rounded-full" :class="selected === '' ? 'bg-leaf' : 'bg-transparent'"></div>
                                Semua Role
                            </button>
                            <button @click="select('admin', 'Admin')" class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-left hover:bg-mint/30 transition-colors" :class="selected === 'admin' ? 'text-leaf bg-mint/10 font-medium' : 'text-slate'">
                                <div class="w-1.5 h-1.5 rounded-full" :class="selected === 'admin' ? 'bg-leaf' : 'bg-transparent'"></div>
                                Admin
                            </button>
                            <button @click="select('user', 'User')" class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-left hover:bg-mint/30 transition-colors" :class="selected === 'user' ? 'text-leaf bg-mint/10 font-medium' : 'text-slate'">
                                <div class="w-1.5 h-1.5 rounded-full" :class="selected === 'user' ? 'bg-leaf' : 'bg-transparent'"></div>
                                User
                            </button>
                        </div>
                    </div>
                </div>

                <div class="h-8 w-px bg-gray-100"></div>

                <button onclick="fetchUsers()" class="p-2.5 text-slate hover:text-leaf hover:bg-mint/50 rounded-xl transition shadow-sm border border-transparent hover:border-mint" title="Refresh">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-eggshell/50">
                    <tr class="text-left text-xs font-semibold text-slate uppercase tracking-wider">
                        <th class="py-4 px-6">Pengguna</th>
                        <th class="py-4 px-6">Email</th>
                        <th class="py-4 px-6">Role</th>
                        <th class="py-4 px-6">Tanggal Daftar</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody" class="divide-y divide-gray-50">
                    <!-- Loading State -->
                    <tr id="loadingRow">
                        <td colspan="5" class="py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="animate-spin h-8 w-8 text-leaf" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-slate text-sm">Memuat data pengguna...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.users.modal')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Settingan buat Axios biar ada CSRF tokennya (biar aman)
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    const tableBody = document.getElementById('userTableBody');
    const modal = document.getElementById('userModal');
    const form = document.getElementById('userForm');
    const modalTitle = document.getElementById('modalTitle');
    const passwordHint = document.getElementById('password-hint');

    // Get data user dari server (Read)
    function fetchUsers() {
        console.log('Lagi ngambil data user nih...');
        
        // Loading
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="py-12 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <svg class="animate-spin h-8 w-8 text-leaf" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-slate text-sm">Sabar ya, lagi muat data...</span>
                    </div>
                </td>
            </tr>
        `;

        const roleFilter = document.getElementById('roleFilter').value;
        
        axios.get("{{ route('admin.users.index') }}", {
            params: {
                role: roleFilter
            }
        })
            .then(response => {
                console.log('Dapet nih datanya:', response.data);
                const users = response.data.data;
                let html = '';

                // Update statistik
                const totalUsers = users.length;
                const totalAdmins = users.filter(u => u.roles && u.roles.some(r => r.name === 'admin')).length;
                const totalRegularUsers = users.filter(u => u.roles && u.roles.some(r => r.name === 'user')).length;

                document.getElementById('totalUsers').textContent = totalUsers;
                document.getElementById('totalAdmins').textContent = totalAdmins;
                document.getElementById('totalRegularUsers').textContent = totalRegularUsers;
                
                if (users.length === 0) {
                    html = `
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                                        <svg class="h-8 w-8 text-slate" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-charcoal font-medium">Belum ada pengguna nih</p>
                                    <p class="text-slate text-sm">Klik tombol "Tambah User" buat nambahin baru</p>
                                </div>
                            </td>
                        </tr>
                    `;
                } else {
                    users.forEach((user, index) => {
                        const roleName = user.roles && user.roles.length > 0 ? user.roles[0].name : '-';
                        const isAdmin = roleName === 'admin';
                        const roleColor = isAdmin ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700';
                        const roleIcon = isAdmin 
                            ? `<svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>`
                            : `<svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>`;

                        // Format tanggal 
                        const createdAt = user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';
                        
                        // Init nama ava
                        const initials = user.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                        const avatarColors = ['bg-leaf', 'bg-coral', 'bg-blue-500', 'bg-purple-500', 'bg-amber-500'];
                        const avatarColor = avatarColors[index % avatarColors.length];

                        html += `
                            <tr class="hover:bg-eggshell/50 transition group">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full ${avatarColor} text-white font-semibold text-sm">
                                            ${initials}
                                        </div>
                                        <div>
                                            <p class="font-medium text-charcoal">${user.name}</p>
                                            <p class="text-xs text-slate">ID: ${user.id}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-charcoal">${user.email}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full ${roleColor}">
                                        ${roleIcon}
                                        ${roleName.charAt(0).toUpperCase() + roleName.slice(1)}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-slate text-sm">${createdAt}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="editUser(${user.id})" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>
                                        <button onclick="deleteUser(${user.id})" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-tomato hover:bg-red-100 transition">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                }
                tableBody.innerHTML = html;
            })
            .catch(error => {
                console.error('Waduh error pas ngambil data:', error);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                                    <svg class="h-8 w-8 text-tomato" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <p class="text-charcoal font-medium">Gagal memuat data nih</p>
                                <p class="text-slate text-sm">Coba refresh halaman deh</p>
                                <button onclick="fetchUsers()" class="mt-2 px-4 py-2 bg-leaf text-white text-sm rounded-lg hover:bg-emerald-600 transition">
                                    Coba Lagi
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
    }

    const modalOverlay = document.getElementById('modalOverlay');
    const modalPanel = document.getElementById('modalPanel');

    // open close modal
    function openModal() {
        resetForm();
        modal.classList.remove('hidden');
        
        // animate
        setTimeout(() => {
            modalOverlay.classList.remove('opacity-0');
            modalPanel.classList.remove('opacity-0', 'scale-95');
            modalPanel.classList.add('opacity-100', 'scale-100');
        }, 10);

        modalTitle.innerText = 'Tambah User';
        if (passwordHint) passwordHint.innerText = 'Min. 8 karakter';
        document.getElementById('saveBtnText').innerText = 'Simpan';
    }

    function closeModal() {
        // close modal
        modalOverlay.classList.add('opacity-0');
        modalPanel.classList.remove('opacity-100', 'scale-100');
        modalPanel.classList.add('opacity-0', 'scale-95');

        // animate
        setTimeout(() => {
            modal.classList.add('hidden');
            resetForm();
        }, 300);
    }

    function resetForm() {
        form.reset();
        document.getElementById('userId').value = '';
        document.querySelectorAll('[id^="error-"]').forEach(el => el.classList.add('hidden'));
        
        // reset input style
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-200');
            input.classList.add('border-gray-200', 'focus:border-leaf', 'focus:ring-leaf/20');
        });
    }

    // edit user
    function editUser(id) {
        // clear form
        resetForm();

        axios.get(`/admin/users/${id}/edit`)
            .then(response => {
                const user = response.data.data;
                document.getElementById('userId').value = user.id;
                document.getElementById('name').value = user.name;
                document.getElementById('email').value = user.email;
                
                if (user.roles && user.roles.length > 0) {
                    document.getElementById('role').value = user.roles[0].name;
                }

                modalTitle.innerText = 'Edit User';
                document.getElementById('saveBtnText').innerText = 'Simpan Perubahan';
                
                // close hint password kalau lagi edit (soalnya password opsional)
                if (document.getElementById('password-hint-text')) {
                   document.getElementById('password-hint-text').classList.add('hidden');
                }
                
                // animate modal
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalOverlay.classList.remove('opacity-0');
                    modalPanel.classList.remove('opacity-0', 'scale-95');
                    modalPanel.classList.add('opacity-100', 'scale-100');
                }, 10);
            })
            .catch(error => {
                console.error('Error pas mau edit:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal memuat data user.',
                    confirmButtonColor: '#2E9A62'
                });
            });
    }

    // save user, bs edit atau buat sih
    function saveUser() {
        const id = document.getElementById('userId').value;
        const url = id ? `/admin/users/${id}` : "{{ route('admin.users.store') }}";
        const method = id ? 'put' : 'post';
        
        // clear error highlight
        document.querySelectorAll('.text-tomato').forEach(el => {
            if (el.id && el.id.startsWith('error-')) {
                el.classList.add('hidden');
            }
        });
        
        // reset input style
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-200');
            input.classList.add('border-gray-200', 'focus:border-leaf', 'focus:ring-leaf/20');
        });

        // loading
        const saveBtn = document.getElementById('saveBtn');
        const saveBtnText = document.getElementById('saveBtnText');
        const originalText = saveBtnText.innerText;
        saveBtn.disabled = true;
        saveBtnText.innerText = 'Menyimpan...';

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        console.log('Lagi nyimpen data:', { url, method, data });

        axios({
            method: method,
            url: url,
            data: data
        })
        .then(response => {
            closeModal();
            // close modal and refresh table
            setTimeout(() => {
                fetchUsers();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Disimpan!',
                    text: response.data.message,
                    timer: 2000,
                    showConfirmButton: false,
                    padding: '2rem',
                    customClass: {
                        popup: 'rounded-3xl shadow-2xl',
                        title: 'text-2xl font-bold text-charcoal mt-1',
                        htmlContainer: 'text-slate text-sm font-medium mt-2',
                        timerProgressBar: 'bg-leaf'
                    }
                });
            }, 300);
        })
        .catch(error => {
            console.error('Yah gagal nyimpen:', error);
            if (error.response && error.response.status === 422) {
                // bounce modal
                const modalPanel = document.getElementById('modalPanel');
                modalPanel.classList.add('animate-error-bounce');
                setTimeout(() => {
                    modalPanel.classList.remove('animate-error-bounce');
                }, 400);

                const errors = error.response.data.errors;
                for (const key in errors) {
                    const errorEl = document.getElementById(`error-${key}`);
                    if (errorEl) {
                        errorEl.innerText = errors[key][0];
                        errorEl.classList.remove('hidden');
                    }
                    
                    // highlight input kl error
                    const inputEl = document.getElementById(key);
                    if (inputEl) {
                        inputEl.classList.remove('border-gray-200', 'focus:border-leaf', 'focus:ring-leaf/20');
                        inputEl.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-200');
                    }
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Terjadi kesalahan sistem, coba lagi nanti.',
                    confirmButtonColor: '#2E9A62'
                });
            }
        })
        .finally(() => {
            saveBtn.disabled = false;
            saveBtnText.innerText = originalText;
        });
    }

    // delete user
    function deleteUser(id) {
        Swal.fire({
            title: 'Hapus Pengguna?',
            text: "Kalo dihapus ga bisa balik lagi lho!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            padding: '2rem',
            customClass: {
                popup: 'rounded-2xl shadow-xl',
                confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 transition-all transform hover:scale-105 shadow-lg shadow-red-500/30 ml-2',
                cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-75 transition-all mr-2',
                title: 'text-xl font-bold text-charcoal',
                htmlContainer: 'text-slate text-sm'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`/admin/users/${id}`)
                    .then(response => {
                        fetchUsers();
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: response.data.message,
                            timer: 2000,
                            showConfirmButton: false,
                            padding: '2rem',
                            customClass: {
                                popup: 'rounded-3xl shadow-2xl',
                                title: 'text-2xl font-bold text-charcoal',
                                htmlContainer: 'text-slate text-sm font-medium',
                                timerProgressBar: 'bg-leaf'
                            },
                        });
                    })
                    .catch(error => {
                        console.error('Gagal menghapus:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Ada masalah pas mau menghapus.',
                            confirmButtonText: 'Tutup',
                            customClass: {
                                popup: 'rounded-2xl shadow-xl',
                                confirmButton: 'bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded-xl'
                            },
                            buttonsStyling: false
                        });
                    });
            }
        });
    }

    // ready page, fetch user
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Halaman siap, gas ambil data user...');
        fetchUsers();
    });
</script>
@endpush
