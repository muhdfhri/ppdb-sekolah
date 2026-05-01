{{-- resources/views/admin/kelolapengguna/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')

    {{-- ── Header ──────────────────────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Kelola Pengguna</h2>
            <p class="text-slate-500 mt-1">Manajemen akun admin dan siswa</p>
        </div>
        <button onclick="openModal('modalTambah')"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-bold shadow hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined text-base">person_add</span>
            Tambah Pengguna
        </button>
    </div>

    {{-- ── Filter & Search ─────────────────────────────────────────── --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-4 mt-4">
        <form method="GET" action="{{ route('admin.pengguna.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 outline-none placeholder:text-slate-400" />
            </div>
            <select name="role"
                class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-primary/20 outline-none">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="siswa" {{ request('role') === 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
            <button type="submit"
                class="px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity">
                Filter
            </button>
            @if(request('search') || request('role'))
                <a href="{{ route('admin.pengguna.index') }}"
                    class="px-5 py-2.5 border border-slate-200 dark:border-slate-700 text-slate-500 rounded-xl text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ── Tabel Pengguna ───────────────────────────────────────────── --}}
    <div
        class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden mt-4">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="font-bold">Daftar Pengguna</h3>
            <span class="text-xs text-slate-400 font-medium">Total: {{ $pengguna->total() }} pengguna</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                        <th class="text-left px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Pengguna
                        </th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Terdaftar
                        </th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($pengguna as $user)
                        @php
                            $roleCfg = $user->role === 'admin'
                                ? ['bg' => 'rgba(1,137,62,0.1)', 'color' => '#01893e', 'label' => 'Admin']
                                : ['bg' => 'rgba(59,130,246,0.1)', 'color' => '#3b82f6', 'label' => 'Siswa'];
                            $isMe = $user->id === auth()->id();
                        @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-9 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                        style="background-color: {{ $user->role === 'admin' ? '#01893e' : '#3b82f6' }};">
                                        {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900 dark:text-white">
                                            {{ $user->nama_lengkap }}
                                            @if($isMe)
                                                <span class="ml-1 text-[10px] font-bold text-primary">(Anda)</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-xs text-slate-500">{{ $user->email }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold"
                                    style="background-color: {{ $roleCfg['bg'] }}; color: {{ $roleCfg['color'] }};">
                                    <span class="size-1.5 rounded-full shrink-0"
                                        style="background-color: {{ $roleCfg['color'] }};"></span>
                                    {{ $roleCfg['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-xs text-slate-500">
                                {{ $user->created_at->locale('id')->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <button
                                        onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->nama_lengkap) }}', '{{ $user->email }}', '{{ $user->role }}')"
                                        class="p-2 rounded-lg text-slate-400 hover:text-primary hover:bg-primary/10 transition-colors"
                                        title="Edit">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </button>
                                    @if(!$isMe)
                                        <button
                                            onclick="confirmDeleteUser({{ $user->id }}, '{{ addslashes($user->nama_lengkap) }}')"
                                            class="p-2 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors"
                                            title="Hapus">
                                            <span class="material-symbols-outlined text-base">delete</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-4xl block mb-2">manage_accounts</span>
                                <p class="text-sm font-semibold">Belum ada pengguna</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pengguna->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                {{ $pengguna->links() }}
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script>
        const baseUrl = "{{ url('admin/pengguna') }}";

        // ============================================================
        // MODAL DELETE (HAPUS)
        // ============================================================
        function openDeleteModal(formId, title, name) {
            window._deleteFormId = formId;
            const titleEl = document.getElementById('modal-title');
            const typeLabelEl = document.getElementById('modal-type-label');
            const itemNameEl = document.getElementById('modal-item-name');

            if (titleEl) titleEl.textContent = title;
            if (typeLabelEl) typeLabelEl.textContent = 'Pengguna';
            if (itemNameEl) itemNameEl.textContent = name;

            const overlay = document.getElementById('modal-delete-overlay');
            if (overlay) {
                overlay.style.display = 'flex';
                const modalCard = overlay.querySelector('div');
                if (modalCard) {
                    modalCard.style.transform = 'scale(0.95)';
                    modalCard.style.transition = 'transform 0.15s ease';
                    requestAnimationFrame(() => {
                        modalCard.style.transform = 'scale(1)';
                    });
                }
            }
        }

        function closeDeleteModal() {
            const overlay = document.getElementById('modal-delete-overlay');
            if (overlay) {
                const modalCard = overlay.querySelector('div');
                if (modalCard) {
                    modalCard.style.transform = 'scale(0.95)';
                    setTimeout(() => { overlay.style.display = 'none'; }, 120);
                } else {
                    overlay.style.display = 'none';
                }
            }
            window._deleteFormId = null;
        }

        function confirmDeleteUser(id, namaLengkap) {
            if (!document.getElementById(`delete-user-form-${id}`)) {
                const form = document.createElement('form');
                form.id = `delete-user-form-${id}`;
                form.action = `${baseUrl}/${id}`;
                form.method = 'POST';
                form.style.display = 'none';
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
            }
            openDeleteModal(`delete-user-form-${id}`, 'Hapus Pengguna?', namaLengkap);
        }

        // ============================================================
        // MODAL TAMBAH & EDIT
        // ============================================================
        function openModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.display = 'flex';
                const modalCard = el.querySelector('div:first-child');
                if (modalCard) {
                    modalCard.style.transform = 'scale(0.95)';
                    requestAnimationFrame(() => {
                        modalCard.style.transform = 'scale(1)';
                    });
                }
            }
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) {
                const modalCard = el.querySelector('div:first-child');
                if (modalCard) {
                    modalCard.style.transform = 'scale(0.95)';
                    setTimeout(() => { el.style.display = 'none'; }, 120);
                } else {
                    el.style.display = 'none';
                }
            }
        }

        function openEditModal(id, nama, email, role) {
            document.getElementById('editNama').value = nama;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = role;
            document.getElementById('formEdit').action = `${baseUrl}/${id}`;

            const errorMessages = document.querySelectorAll('#modalEdit .text-red-500');
            errorMessages.forEach(msg => msg.remove());

            openModal('modalEdit');
        }

        // ============================================================
        // VALIDASI PASSWORD REAL-TIME
        // ============================================================
        // ============================================================
        // VALIDASI PASSWORD REAL-TIME (SEDERHANA)
        // ============================================================
        function validatePassword(password) {
            return {
                length: password.length >= 8,
                lowercase: /[a-z]/.test(password),
                uppercase: /[A-Z]/.test(password)
            };
        }

        function updateRequirementUI(element, isValid) {
            if (!element) return;
            const icon = element.querySelector('.material-symbols-outlined');
            const text = element.querySelector('span:last-child');

            if (isValid) {
                if (icon) {
                    icon.textContent = 'check_circle';
                    icon.classList.remove('text-slate-400');
                    icon.classList.add('text-green-500');
                }
                if (text) {
                    text.classList.remove('text-slate-500');
                    text.classList.add('text-green-600');
                }
            } else {
                if (icon) {
                    icon.textContent = 'circle';
                    icon.classList.remove('text-green-500');
                    icon.classList.add('text-slate-400');
                }
                if (text) {
                    text.classList.remove('text-green-600');
                    text.classList.add('text-slate-500');
                }
            }
        }

        function updatePasswordRequirements() {
            const passwordInput = document.getElementById('password');
            if (!passwordInput) return;

            const password = passwordInput.value;
            const req = validatePassword(password);

            updateRequirementUI(document.getElementById('reqLength'), req.length);
            updateRequirementUI(document.getElementById('reqLowercase'), req.lowercase);
            updateRequirementUI(document.getElementById('reqUppercase'), req.uppercase);

            checkPasswordMatch();
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password')?.value || '';
            const confirm = document.getElementById('passwordConfirmation')?.value || '';
            const indicator = document.getElementById('passwordMatchIndicator');

            if (!indicator) return;

            if (confirm.length > 0) {
                if (password === confirm) {
                    indicator.innerHTML = '<span class="text-green-600 flex items-center gap-1"><span class="material-symbols-outlined text-xs">check_circle</span> Password cocok</span>';
                    indicator.classList.remove('hidden');
                } else {
                    indicator.innerHTML = '<span class="text-red-500 flex items-center gap-1"><span class="material-symbols-outlined text-xs">error</span> Password tidak cocok</span>';
                    indicator.classList.remove('hidden');
                }
            } else {
                indicator.classList.add('hidden');
                indicator.innerHTML = '';
            }
        }

        function resetPasswordValidation() {
            const requirements = ['reqLength', 'reqLowercase', 'reqUppercase'];
            requirements.forEach(reqId => {
                const element = document.getElementById(reqId);
                if (element) {
                    const icon = element.querySelector('.material-symbols-outlined');
                    const text = element.querySelector('span:last-child');
                    if (icon) {
                        icon.textContent = 'circle';
                        icon.classList.remove('text-green-500');
                        icon.classList.add('text-slate-400');
                    }
                    if (text) {
                        text.classList.remove('text-green-600');
                        text.classList.add('text-slate-500');
                    }
                }
            });
            const indicator = document.getElementById('passwordMatchIndicator');
            if (indicator) {
                indicator.classList.add('hidden');
                indicator.innerHTML = '';
            }
        }

        // ============================================================
        // INJECT MODAL HTML KE BODY
        // ============================================================
        document.addEventListener('DOMContentLoaded', function () {
            // Modal Delete Overlay
            const modalDeleteHTML = `
                            <div id="modal-delete-overlay"
                                style="display:none; position:fixed; inset:0; width:100vw; height:100vh;
                                       background:rgba(0,0,0,0.6); backdrop-filter:blur(3px);
                                       z-index:99999; align-items:center; justify-content:center; padding:1rem;">
                                <div style="background:white; border-radius:1.25rem;
                                            box-shadow:0 25px 60px rgba(0,0,0,0.25);
                                            width:100%; max-width:380px; padding:2rem;">
                                    <div style="width:56px; height:56px; border-radius:50%;
                                                background:rgba(239,68,68,0.1); display:flex;
                                                align-items:center; justify-content:center; margin:0 auto 1rem;">
                                        <span class="material-symbols-outlined" style="font-size:28px; color:#ef4444;">delete_forever</span>
                                    </div>
                                    <h3 id="modal-title" style="text-align:center; font-weight:800; font-size:1.1rem;
                                           color:#0f172a; margin:0 0 0.5rem;">Hapus Pengguna?</h3>
                                    <p style="text-align:center; color:#64748b; font-size:0.875rem; margin:0 0 0.25rem;">
                                        <span id="modal-type-label" style="font-size:0.75rem; font-weight:600;
                                            color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em;
                                            display:block; margin-bottom:0.5rem;"></span>
                                        "<span id="modal-item-name" style="font-weight:700; color:#334155;"></span>"
                                        akan dihapus secara permanen.
                                    </p>
                                    <p style="text-align:center; color:#94a3b8; font-size:0.75rem; margin:0 0 1.5rem;">
                                        Tindakan ini <strong style="color:#ef4444;">tidak dapat dibatalkan</strong>.
                                    </p>
                                    <div style="display:flex; gap:0.75rem;">
                                        <button id="modal-btn-batal"
                                            style="flex:1; padding:0.75rem; border-radius:0.75rem; font-weight:700;
                                                   font-size:0.875rem; color:#475569; background:#f1f5f9;
                                                   border:none; cursor:pointer; transition:background 0.15s;"
                                            onmouseover="this.style.background='#e2e8f0';"
                                            onmouseout="this.style.background='#f1f5f9';">Batal</button>
                                        <button id="modal-btn-hapus"
                                            style="flex:1; padding:0.75rem; border-radius:0.75rem; font-weight:700;
                                                   font-size:0.875rem; color:white; background:#ef4444;
                                                   border:none; cursor:pointer; transition:background 0.15s;
                                                   display:flex; align-items:center; justify-content:center; gap:0.4rem;"
                                            onmouseover="this.style.background='#dc2626';"
                                            onmouseout="this.style.background='#ef4444';">
                                            <span class="material-symbols-outlined" style="font-size:18px;">delete</span>
                                            Ya, Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>`;
            document.body.insertAdjacentHTML('beforeend', modalDeleteHTML);

            // Modal Tambah Pengguna
            const modalTambahHTML = `
                            <div id="modalTambah" class="fixed inset-0 z-[99998] hidden items-center justify-center p-4"
                                 style="background:rgba(0,0,0,0.6); backdrop-filter:blur(3px);">
                                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800 sticky top-0 bg-white dark:bg-slate-900 z-10">
                                        <div class="flex items-center gap-3">
                                            <div class="size-9 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                                <span class="material-symbols-outlined text-lg">person_add</span>
                                            </div>
                                            <h3 class="font-bold text-base">Tambah Pengguna</h3>
                                        </div>
                                        <button onclick="closeModal('modalTambah')" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                            <span class="material-symbols-outlined text-xl">close</span>
                                        </button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.pengguna.store') }}" class="px-6 py-5 space-y-4">
                                        @csrf
                                        @if($errors->any() && !old('_method'))
                                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-3">
                                                <div class="flex items-start gap-2">
                                                    <span class="material-symbols-outlined text-red-500 text-sm shrink-0">error</span>
                                                    <div class="text-xs text-red-600 dark:text-red-400">
                                                        <p class="font-semibold mb-1">Gagal menambahkan pengguna:</p>
                                                        @foreach($errors->all() as $error)
                                                            <p>• {{ $error }}</p>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                            <input type="text" name="nama_lengkap" required placeholder="Masukkan nama lengkap" value="{{ old('nama_lengkap') }}"
                                                class="w-full px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none @error('nama_lengkap') ring-2 ring-red-500/30 @enderror" />
                                            @error('nama_lengkap') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5">Email <span class="text-red-500">*</span></label>
                                            <input type="email" name="email" required placeholder="contoh@email.com" value="{{ old('email') }}"
                                                class="w-full px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none @error('email') ring-2 ring-red-500/30 @enderror" />
                                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5">Role <span class="text-red-500">*</span></label>
                                            <select name="role" required class="w-full px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none">
                                                <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            @error('role') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                       <div>
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" id="password" required placeholder="Masukkan password"
                        class="w-full px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none placeholder:text-slate-400 @error('password') ring-2 ring-red-500/30 @enderror" />

                    {{-- Password Requirements List --}}
                    <div class="mt-2 space-y-1" id="passwordRequirements">
                        <p class="text-[10px] font-semibold text-slate-500 mb-1">Password harus memenuhi:</p>
                        <div class="flex flex-wrap gap-x-4 gap-y-1">
                            <div class="flex items-center gap-1.5 requirement" id="reqLength">
                                <span class="material-symbols-outlined text-xs text-slate-400">circle</span>
                                <span class="text-[10px] text-slate-500">Minimal 8 karakter</span>
                            </div>
                            <div class="flex items-center gap-1.5 requirement" id="reqLowercase">
                                <span class="material-symbols-outlined text-xs text-slate-400">circle</span>
                                <span class="text-[10px] text-slate-500">Huruf kecil (a-z)</span>
                            </div>
                            <div class="flex items-center gap-1.5 requirement" id="reqUppercase">
                                <span class="material-symbols-outlined text-xs text-slate-400">circle</span>
                                <span class="text-[10px] text-slate-500">Huruf besar (A-Z)</span>
                            </div>
                        </div>
                    </div>

                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                                            <input type="password" name="password_confirmation" id="passwordConfirmation" required placeholder="Ulangi password"
                                                class="w-full px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none" />
                                            <div id="passwordMatchIndicator" class="mt-1 text-[10px] hidden"></div>
                                        </div>
                                        <div class="flex gap-3 pt-2">
                                            <button type="button" onclick="closeModal('modalTambah')" class="flex-1 py-2.5 border border-slate-200 dark:border-slate-700 text-slate-500 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors">Batal</button>
                                            <button type="submit" class="flex-1 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>`;
            document.body.insertAdjacentHTML('beforeend', modalTambahHTML);

            // Modal Edit Pengguna
            const modalEditHTML = `
                            <div id="modalEdit" class="fixed inset-0 z-[99998] hidden items-center justify-center p-4"
                                 style="background:rgba(0,0,0,0.6); backdrop-filter:blur(3px);">
                                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800 sticky top-0 bg-white dark:bg-slate-900 z-10">
                                        <div class="flex items-center gap-3">
                                            <div class="size-9 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </div>
                                            <h3 class="font-bold text-base">Edit Pengguna</h3>
                                        </div>
                                        <button onclick="closeModal('modalEdit')" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 transition-colors">
                                            <span class="material-symbols-outlined text-xl">close</span>
                                        </button>
                                    </div>
                                    <form method="POST" id="formEdit" class="px-6 py-5 space-y-4">
                                        @csrf @method('PUT')
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                            <input type="text" name="nama_lengkap" id="editNama" required class="w-full px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none" />
                                            @error('nama_lengkap') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5">Email <span class="text-red-500">*</span></label>
                                            <input type="email" name="email" id="editEmail" required class="w-full px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none" />
                                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5">Role <span class="text-red-500">*</span></label>
                                            <select name="role" id="editRole" class="w-full px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none">
                                                <option value="siswa">Siswa</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                            @error('role') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="flex gap-3 pt-2">
                                            <button type="button" onclick="closeModal('modalEdit')" class="flex-1 py-2.5 border border-slate-200 dark:border-slate-700 text-slate-500 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors">Batal</button>
                                            <button type="submit" class="flex-1 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>`;
            document.body.insertAdjacentHTML('beforeend', modalEditHTML);

            // Event Listeners untuk Delete Modal
            document.getElementById('modal-btn-batal')?.addEventListener('click', closeDeleteModal);
            document.getElementById('modal-btn-hapus')?.addEventListener('click', function () {
                if (window._deleteFormId) document.getElementById(window._deleteFormId).submit();
            });
            document.getElementById('modal-delete-overlay')?.addEventListener('click', function (e) {
                if (e.target === this) closeDeleteModal();
            });

            // Event Listeners untuk Validasi Password
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('passwordConfirmation');
            if (passwordInput) passwordInput.addEventListener('input', updatePasswordRequirements);
            if (confirmInput) confirmInput.addEventListener('input', checkPasswordMatch);

            // Event untuk reset validasi saat modal tambah dibuka
            const tambahBtn = document.querySelector('[onclick="openModal(\'modalTambah\')"]');
            if (tambahBtn) {
                tambahBtn.addEventListener('click', function () {
                    setTimeout(resetPasswordValidation, 100);
                });
            }

            // ESC Key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeDeleteModal();
                    closeModal('modalTambah');
                    closeModal('modalEdit');
                }
            });

            // Buka modal jika ada validation error
            @if($errors->any())
                @if(old('_method') == 'PUT')
                    openModal('modalEdit');
                @else
                    openModal('modalTambah');
                @endif
            @endif
                        });
    </script>
@endpush