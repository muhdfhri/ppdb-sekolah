<footer class="py-16" style="background-color: #0f2318; color: #cbd5e1;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

            {{-- Brand --}}
            <div class="col-span-1 lg:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="size-10 rounded-full flex items-center justify-center p-0.5 overflow-hidden"
                        style="background-color: white;">
                        <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK NU II Medan"
                            class="w-full h-full object-contain rounded-full">
                    </div>
                    <h2 class="text-xl font-bold uppercase" style="color: white;">SMK NU II Medan</h2>
                </div>
                <p class="mb-6 max-w-md text-sm leading-relaxed">
                    Lembaga pendidikan kejuruan di bawah naungan Nahdatul Ulama yang berkomitmen
                    mencetak tenaga kerja profesional yang mandiri dan berakhlakul karimah.
                </p>
                {{-- Social Icons --}}
                <div class="flex gap-3">
                    <a href="https://www.instagram.com/smknu_medan/" target="_blank" rel="noopener noreferrer"
                        class="size-10 rounded-full flex items-center justify-center transition-all hover:scale-110"
                        style="background-color: rgba(255,255,255,0.08);"
                        onmouseover="this.style.backgroundColor='#018B3E';"
                        onmouseout="this.style.backgroundColor='rgba(255,255,255,0.08)';">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0z">
                            </path>
                            <path
                                d="M12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8z">
                            </path>
                            <circle cx="18.406" cy="5.594" r="1.44"></circle>
                        </svg>
                        <span class="sr-only">Instagram</span>
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
                        <span>Jl. Gaperta Ujung No.2, Tj. Gusta, Kec. Medan Helvetia, Kota Medan, Sumatera Utara
                            20125</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-base shrink-0" style="color: #018B3E;">call</span>
                        <span>0812-6685-7686</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-base shrink-0" style="color: #018B3E;">mail</span>
                        <span>smknu2medan22@gmail.com</span>
                    </li>
                </ul>
            </div>

            {{-- Lokasi --}}
            <div>
                <h4 class="font-bold mb-6 text-sm uppercase tracking-wider" style="color: #F6CB04;">Lokasi</h4>
                <div class="w-full h-48 md:h-56 lg:h-64 rounded-xl overflow-hidden border shadow-md"
                    style="border-color: rgba(1,139,62,0.3);">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.923385045066!2d98.62424907371665!3d3.6050143501838887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30312f530ccc9f75%3A0x6e8e194f359c34d3!2sSMK%20SWASTA%20NU%20MEDAN!5e0!3m2!1sid!2sid!4v1773286735424!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" title="Lokasi SMK Swasta NU Medan"
                        class="w-full h-full">
                    </iframe>
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