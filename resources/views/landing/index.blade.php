@extends('layouts.app')

@section('title', 'PPDB SMK NU II Medan - Penerimaan Peserta Didik Baru')

@section('content')
    <div class="relative flex min-h-screen flex-col overflow-x-hidden">
        @include('partials.navbar')

        {{-- Hero Section --}}
        <section class="relative py-16 lg:py-24 overflow-hidden" id="beranda"
            style="background-color: var(--color-background-light, #F6F4F7);">
            {{-- Decorative blobs menggunakan warna dari CSS variables --}}
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl opacity-20 pointer-events-none"
                style="background-color: #018B3E;"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full blur-3xl opacity-15 pointer-events-none"
                style="background-color: #F6CB04;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="flex flex-col gap-6 text-left z-10">
                        {{-- Badge --}}
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full w-fit font-bold text-xs uppercase tracking-wider"
                            style="background-color: rgba(1,139,62,0.12); color: #018B3E;">
                            <span class="material-symbols-outlined text-sm">campaign</span>
                            <span>PPDB Telah Dibuka</span>
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight tracking-tight"
                            style="color: #0f2318;">
                            Penerimaan Peserta Didik Baru
                            <span style="color: #018B3E;">(PPDB)</span>
                            Tahun Pelajaran 2026/2027
                        </h1>

                        <p class="text-lg max-w-xl" style="color: #3a5a46;">
                            Wujudkan masa depan gemilang dengan pendidikan vokasi berkualitas, fasilitas modern, dan
                            penguatan karakter Islami di SMK Swasta Nahdatul Ulama II Medan.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 mt-4">
                            <a href="{{ route('register') }}"
                                class="px-8 py-4 rounded-xl font-black text-lg shadow-lg flex items-center justify-center gap-2 hover:brightness-105 transition-all"
                                style="background-color: #F6CB04; color: #0f2318;">
                                Daftar Sekarang
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                            <button
                                class="border-2 px-8 py-4 rounded-xl font-bold text-lg flex items-center justify-center gap-2 transition-all hover:text-white"
                                style="border-color: #018B3E; color: #018B3E;"
                                onmouseover="this.style.backgroundColor='#018B3E'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#018B3E';">
                                Brosur Digital
                                <span class="material-symbols-outlined">download</span>
                            </button>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -top-10 -right-10 w-64 h-64 rounded-full blur-3xl opacity-10"
                            style="background-color: #018B3E;"></div>
                        <div class="absolute -bottom-10 -left-10 w-64 h-64 rounded-full blur-3xl opacity-20"
                            style="background-color: #F6CB04;"></div>
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border-8 aspect-[4/3] bg-slate-200"
                            style='border-color: white; background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCOwp-RC4hGiFTHDZOa2qM7cV2VqCAEvp7D9NPL3KXDgz4-_QmIRuIPE-nfBy24j2JGrRwfjUJhZd63Pm-3L60afTC787lsMNaDK_bFvdFS-zmRpMysFIaYWT9ZrugTxne49DG6Hy6HbwtNtjHDRlVrWH8FK1EGtmN40r4hgHddoEgmYBjO99WSivzK355XQtd0UtPO5TVom9KMbjjigsp0dnp9use3rWwJbRAGwiGjDhu4lYHVUtYsE91dTuDPZCfuvn0t82ioObc"); background-size: cover; background-position: center;'>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Stats Bar --}}
        <div style="background-color: #018B3E;" class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
                    <div>
                        <div class="text-3xl font-black" style="color: #F6CB04;">500+</div>
                        <div class="text-sm opacity-80 mt-1">Siswa Aktif</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black" style="color: #F6CB04;">4</div>
                        <div class="text-sm opacity-80 mt-1">Jurusan Unggulan</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black" style="color: #F6CB04;">50+</div>
                        <div class="text-sm opacity-80 mt-1">Mitra Industri</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black" style="color: #F6CB04;">A</div>
                        <div class="text-sm opacity-80 mt-1">Akreditasi BNSP</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tentang Section --}}
        <section class="py-20" id="tentang" style="background-color: white;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="font-bold text-sm tracking-widest uppercase mb-2 block"
                        style="color: #018B3E;">Kenapa Memilih Kami?</span>
                    <h3 class="text-3xl sm:text-4xl font-black" style="color: #0f2318;">Tentang SMK NU II Medan</h3>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    {{-- Card 1 --}}
                    <div class="p-8 rounded-2xl border shadow-sm hover:shadow-md transition-shadow"
                        style="background-color: #F6F4F7; border-color: rgba(1,139,62,0.12);">
                        <div class="size-14 text-white rounded-xl flex items-center justify-center mb-6"
                            style="background-color: #018B3E;">
                            <span class="material-symbols-outlined text-3xl">workspace_premium</span>
                        </div>
                        <h4 class="text-xl font-bold mb-3" style="color: #0f2318;">Akreditasi Unggul</h4>
                        <p style="color: #3a5a46;">Kurikulum kami telah disesuaikan dengan kebutuhan industri modern dan
                            terakreditasi oleh BNSP.</p>
                    </div>
                    {{-- Card 2 --}}
                    <div class="p-8 rounded-2xl border shadow-sm hover:shadow-md transition-shadow"
                        style="background-color: #F6F4F7; border-color: rgba(1,139,62,0.12);">
                        <div class="size-14 text-white rounded-xl flex items-center justify-center mb-6"
                            style="background-color: #018B3E;">
                            <span class="material-symbols-outlined text-3xl">biotech</span>
                        </div>
                        <h4 class="text-xl font-bold mb-3" style="color: #0f2318;">Fasilitas Modern</h4>
                        <p style="color: #3a5a46;">Laboratorium praktik lengkap mulai dari Teknik Komputer, Akuntansi,
                            hingga Workshop Otomotif.</p>
                    </div>
                    {{-- Card 3 --}}
                    <div class="p-8 rounded-2xl border shadow-sm hover:shadow-md transition-shadow"
                        style="background-color: #F6F4F7; border-color: rgba(1,139,62,0.12);">
                        <div class="size-14 text-white rounded-xl flex items-center justify-center mb-6"
                            style="background-color: #018B3E;">
                            <span class="material-symbols-outlined text-3xl">handshake</span>
                        </div>
                        <h4 class="text-xl font-bold mb-3" style="color: #0f2318;">Jejaring Industri</h4>
                        <p style="color: #3a5a46;">Bekerjasama dengan lebih dari 50+ perusahaan nasional untuk program
                            magang dan penempatan kerja.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Alur PPDB --}}
        <section class="py-20" id="alur" style="background-color: #F6F4F7;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="font-bold text-sm tracking-widest uppercase mb-2 block"
                        style="color: #018B3E;">Prosedur Pendaftaran</span>
                    <h3 class="text-3xl sm:text-4xl font-black" style="color: #0f2318;">Alur Pendaftaran (Step-by-Step)</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 relative">
                    <div class="hidden md:block absolute top-12 left-1/4 right-1/4 h-0.5 -z-0"
                        style="background-color: rgba(1,139,62,0.2);"></div>

                    @foreach([
                        ['icon' => 'app_registration', 'step' => '1. Registrasi Online', 'desc' => 'Isi formulir pendaftaran melalui website resmi sekolah.', 'date' => 'Jan - Mar 2026'],
                        ['icon' => 'description', 'step' => '2. Verifikasi Berkas', 'desc' => 'Membawa dokumen asli ke sekolah untuk divalidasi petugas.', 'date' => 'Apr 2026'],
                        ['icon' => 'assignment_turned_in', 'step' => '3. Ujian Seleksi', 'desc' => 'Tes potensi akademik dan wawancara minat bakat.', 'date' => 'Mei 2026'],
                        ['icon' => 'celebration', 'step' => '4. Daftar Ulang', 'desc' => 'Penyelesaian administrasi bagi siswa yang dinyatakan lulus.', 'date' => 'Jun 2026'],
                    ] as $item)
                    <div class="flex flex-col items-center text-center group z-10">
                        <div class="size-20 rounded-full border-4 flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform"
                            style="background-color: white; border-color: #018B3E;">
                            <span class="material-symbols-outlined text-3xl" style="color: #018B3E;">{{ $item['icon'] }}</span>
                        </div>
                        <h5 class="font-bold text-lg mb-2" style="color: #0f2318;">{{ $item['step'] }}</h5>
                        <p class="text-sm mb-2" style="color: #3a5a46;">{{ $item['desc'] }}</p>
                        <span class="text-xs font-bold px-2 py-1 rounded"
                            style="color: #018B3E; background-color: rgba(1,139,62,0.1);">{{ $item['date'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Syarat & Dokumen --}}
        <section class="py-20" id="syarat" style="background-color: white;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <span class="font-bold text-sm tracking-widest uppercase mb-2 block"
                            style="color: #018B3E;">Persiapan</span>
                        <h3 class="text-3xl sm:text-4xl font-black mb-6" style="color: #0f2318;">Syarat & Dokumen
                            Pendaftaran</h3>
                        <p class="mb-8" style="color: #3a5a46;">Pastikan seluruh dokumen dalam format fisik maupun digital
                            (Scan PDF) telah disiapkan sebelum melakukan pendaftaran online.</p>
                        <div class="space-y-4">
                            @foreach([
                                ['title' => 'Fotokopi Ijazah / SKL', 'sub' => 'Dilegalisir sebanyak 3 lembar.'],
                                ['title' => 'Kartu Keluarga & Akte Kelahiran', 'sub' => 'Fotokopi masing-masing 2 lembar.'],
                                ['title' => 'Pas Foto Terbaru (3x4 & 4x6)', 'sub' => 'Latar belakang merah, 4 lembar.'],
                                ['title' => 'KPS / KIP / PKH (Opsional)', 'sub' => 'Bagi pendaftar jalur bantuan pemerintah.'],
                            ] as $doc)
                            <div class="flex items-start gap-4 p-4 rounded-xl"
                                style="background-color: #F6F4F7;">
                                <span class="material-symbols-outlined" style="color: #018B3E;">check_circle</span>
                                <div>
                                    <p class="font-bold" style="color: #0f2318;">{{ $doc['title'] }}</p>
                                    <p class="text-sm" style="color: #3a5a46;">{{ $doc['sub'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Info card menggunakan primary #018B3E --}}
                    <div class="rounded-3xl p-8 sm:p-12 text-white relative overflow-hidden shadow-2xl"
                        style="background-color: #018B3E;">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <span class="material-symbols-outlined text-[160px]">verified_user</span>
                        </div>
                        <h4 class="text-2xl font-bold mb-4">Informasi Tambahan</h4>
                        <ul class="space-y-4 mb-8">
                            @foreach([
                                'Usia maksimal 21 tahun per Juli 2026.',
                                'Tidak bertato dan tidak bertindik.',
                                'Sehat jasmani dan rohani.',
                            ] as $info)
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined" style="color: #F6CB04;">info</span>
                                <span>{{ $info }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="p-6 rounded-2xl border" style="background-color: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">
                            <p class="text-sm font-medium mb-4">Punya pertanyaan mengenai syarat khusus jurusan?</p>
                            <button
                                class="w-full font-bold py-3 rounded-xl transition-all hover:brightness-110"
                                style="background-color: #F6CB04; color: #0f2318;">
                                Hubungi Admin PPDB
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- FAQ --}}
        <section class="py-20" id="faq" style="background-color: #F6F4F7;">
            <div class="max-w-3xl mx-auto px-4 sm:px-6">
                <div class="text-center mb-16">
                    <span class="font-bold text-sm tracking-widest uppercase mb-2 block"
                        style="color: #018B3E;">Bantuan</span>
                    <h3 class="text-3xl sm:text-4xl font-black" style="color: #0f2318;">Pertanyaan Sering Diajukan</h3>
                </div>
                <div class="space-y-4">
                    @foreach([
                        ['q' => 'Kapan pendaftaran offline dilayani di sekolah?', 'a' => 'Pendaftaran offline dilayani setiap hari Senin - Sabtu, pukul 08.00 s/d 15.00 WIB di Sekretariat PPDB SMK NU II Medan.', 'open' => true],
                        ['q' => 'Berapa biaya pendaftaran awal?', 'a' => 'Biaya pendaftaran untuk tahun ajaran 2026/2027 adalah Gratis. Siswa hanya perlu membayar biaya administrasi daftar ulang jika sudah dinyatakan lulus.', 'open' => false],
                        ['q' => 'Apakah ada beasiswa prestasi?', 'a' => 'Ya, kami menyediakan beasiswa penuh bagi siswa berprestasi di bidang akademik maupun non-akademik tingkat kota/provinsi, serta beasiswa khusus bagi hafidz Qur\'an.', 'open' => false],
                        ['q' => 'Apa saja jurusan yang tersedia?', 'a' => 'Tersedia 4 Kompetensi Keahlian: Teknik Komputer Jaringan (TKJ), Akuntansi & Keuangan Lembaga (AKL), Bisnis Daring & Pemasaran (BDP), dan Multimedia.', 'open' => false],
                    ] as $faq)
                    <div class="collapse collapse-plus shadow-sm border rounded-xl overflow-hidden"
                        style="background-color: white; border-color: rgba(1,139,62,0.15);">
                        <input type="radio" name="faq-accordion" {{ $faq['open'] ? 'checked' : '' }} />
                        <div class="collapse-title text-lg font-bold" style="color: #0f2318;">
                            {{ $faq['q'] }}
                        </div>
                        <div class="collapse-content">
                            <p style="color: #3a5a46;">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        @include('partials.footer')
    </div>
@endsection