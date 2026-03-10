<footer class="py-16" style="background-color: #0f2318; color: #cbd5e1;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

            {{-- Brand --}}
            <div class="col-span-1 lg:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="size-10 rounded-full flex items-center justify-center p-1"
                        style="background-color: #018B3E;">
                        <span class="material-symbols-outlined text-white text-2xl">school</span>
                    </div>
                    <h2 class="text-xl font-bold uppercase" style="color: white;">SMK NU II Medan</h2>
                </div>
                <p class="mb-6 max-w-md text-sm leading-relaxed">
                    Lembaga pendidikan kejuruan di bawah naungan Nahdatul Ulama yang berkomitmen
                    mencetak tenaga kerja profesional yang mandiri dan berakhlakul karimah.
                </p>
                {{-- Social Icons --}}
                <div class="flex gap-3">
                    <a class="size-10 rounded-full flex items-center justify-center transition-all hover:scale-110"
                        style="background-color: rgba(255,255,255,0.08);"
                        onmouseover="this.style.backgroundColor='#018B3E';"
                        onmouseout="this.style.backgroundColor='rgba(255,255,255,0.08)';" href="#">
                        <span class="material-symbols-outlined text-xl">social_leaderboard</span>
                    </a>
                    <a class="size-10 rounded-full flex items-center justify-center transition-all hover:scale-110"
                        style="background-color: rgba(255,255,255,0.08);"
                        onmouseover="this.style.backgroundColor='#018B3E';"
                        onmouseout="this.style.backgroundColor='rgba(255,255,255,0.08)';" href="#">
                        <span class="material-symbols-outlined text-xl">camera_alt</span>
                    </a>
                    <a class="size-10 rounded-full flex items-center justify-center transition-all hover:scale-110"
                        style="background-color: rgba(255,255,255,0.08);"
                        onmouseover="this.style.backgroundColor='#018B3E';"
                        onmouseout="this.style.backgroundColor='rgba(255,255,255,0.08)';" href="#">
                        <span class="material-symbols-outlined text-xl">play_circle</span>
                    </a>
                </div>
            </div>

            {{-- Kontak --}}
            <div>
                <h4 class="font-bold mb-6 text-sm uppercase tracking-wider" style="color: #F6CB04;">Kontak Kami</h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-base shrink-0 mt-0.5"
                            style="color: #018B3E;">location_on</span>
                        <span>Jl. Sidorukun No. 100, Pulo Brayan Darat II, Kec. Medan Tim., Kota Medan, Sumatera Utara
                            20239</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-base shrink-0" style="color: #018B3E;">call</span>
                        <span>(061) 12345678</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-base shrink-0" style="color: #018B3E;">mail</span>
                        <span>info@smknu2medan.sch.id</span>
                    </li>
                </ul>
            </div>

            {{-- Lokasi --}}
            <div>
                <h4 class="font-bold mb-6 text-sm uppercase tracking-wider" style="color: #F6CB04;">Lokasi</h4>
                <div class="w-full h-40 rounded-xl overflow-hidden border"
                    style="border-color: rgba(1,139,62,0.3); background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBa9VCpFQ8PpoeKnVdFdrBCKIT-ZzZheJgI89oKKn-fvTY3GCtci4VFdN2PZUvM0YLDnJl-KtzX3p7m3T9jO8nJXuC6sZzikOD_c7YkfFbeb2C5nbESEJFQ5voGeV_Dc1x7CMZLXpoHmHWPDwg0lgldJ7gsSlbrm48bgMbz64TTDWXF13iL95PdjqTLpkPkFQnzUqBu1sz_zA3wrc9KFBvHLX7c0FjVhT9NSAhcWDxVhezvqUDwqSi3pmQIQffXT6hVYaZY3ZY0fys'); background-size: cover; background-position: center;">
                </div>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="mt-16 pt-8 text-center text-xs"
            style="border-top: 1px solid rgba(255,255,255,0.08); opacity: 0.55;">
            <p>© {{ date('Y') }} SMK Swasta Nahdatul Ulama II Medan. All rights reserved.</p>
        </div>
    </div>
</footer>