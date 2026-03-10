@extends('layouts.app')

@section('title', 'Testing PPDB SMK NU II Medan')

@section('content')
    <div class="min-h-screen p-8">
        <div class="max-w-4xl mx-auto space-y-8">

            {{-- HEADER TEST --}}
            <div class="text-center">
                <h1 class="text-4xl font-black text-primary">🧪 TESTING SUITE</h1>
                <p class="text-slate-600">Verifikasi Tailwind CSS v4 + DaisyUI v5</p>
            </div>

            {{-- TEST WARNA CUSTOM --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-primary">1. Warna Custom</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <div class="p-4 bg-primary text-white rounded-lg text-center">bg-primary</div>
                        <div class="p-4 bg-secondary text-black rounded-lg text-center">bg-secondary</div>
                        <div class="p-4 bg-nu-bg text-nu-dark rounded-lg text-center">bg-nu-bg</div>
                        <div class="p-4 bg-nu-dark text-white rounded-lg text-center">bg-nu-dark</div>
                    </div>
                </div>
            </div>

            {{-- TEST TYPOGRAPHY --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-primary">2. Font Public Sans</h2>
                    <div class="space-y-2">
                        <p class="font-light">Light - The quick brown fox jumps over the lazy dog</p>
                        <p class="font-normal">Regular - The quick brown fox jumps over the lazy dog</p>
                        <p class="font-medium">Medium - The quick brown fox jumps over the lazy dog</p>
                        <p class="font-semibold">Semibold - The quick brown fox jumps over the lazy dog</p>
                        <p class="font-bold">Bold - The quick brown fox jumps over the lazy dog</p>
                        <p class="font-extrabold">Extrabold - The quick brown fox jumps over the lazy dog</p>
                        <p class="font-black">Black - The quick brown fox jumps over the lazy dog</p>
                    </div>
                </div>
            </div>

            {{-- TEST DAISYUI COMPONENTS --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-primary">3. DaisyUI Components</h2>

                    {{-- Badges --}}
                    <div class="flex flex-wrap gap-2 mt-4">
                        <div class="badge badge-primary">Primary</div>
                        <div class="badge badge-secondary">Secondary</div>
                        <div class="badge badge-accent">Accent</div>
                        <div class="badge badge-ghost">Ghost</div>
                        <div class="badge badge-outline">Outline</div>
                        <div class="badge badge-success">Success</div>
                        <div class="badge badge-warning">Warning</div>
                        <div class="badge badge-error">Error</div>
                        <div class="badge badge-info">Info</div>
                        <div class="badge badge-lg">Large</div>
                        <div class="badge badge-sm">Small</div>
                        <div class="badge badge-xs">XSmall</div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-wrap gap-4 mt-6">
                        <button class="btn btn-primary">Primary</button>
                        <button class="btn btn-secondary">Secondary</button>
                        <button class="btn btn-accent">Accent</button>
                        <button class="btn btn-ghost">Ghost</button>
                        <button class="btn btn-outline btn-primary">Outline</button>
                        <button class="btn btn-success">Success</button>
                        <button class="btn btn-warning">Warning</button>
                        <button class="btn btn-error">Error</button>
                        <button class="btn btn-info">Info</button>
                        <button class="btn btn-disabled">Disabled</button>
                        <button class="btn btn-primary btn-outline" disabled>Disabled</button>
                    </div>

                    {{-- Button Sizes --}}
                    <div class="flex flex-wrap items-center gap-4 mt-6">
                        <button class="btn btn-primary btn-xs">XSmall</button>
                        <button class="btn btn-primary btn-sm">Small</button>
                        <button class="btn btn-primary">Normal</button>
                        <button class="btn btn-primary btn-lg">Large</button>
                        <button class="btn btn-primary btn-xl">XLarge</button>
                    </div>

                    {{-- Button with Icons --}}
                    <div class="flex flex-wrap gap-4 mt-6">
                        <button class="btn btn-primary">
                            <span class="material-symbols-outlined">save</span>
                            Save
                        </button>
                        <button class="btn btn-secondary">
                            <span class="material-symbols-outlined">edit</span>
                            Edit
                        </button>
                        <button class="btn btn-error">
                            <span class="material-symbols-outlined">delete</span>
                            Delete
                        </button>
                        <button class="btn btn-success">
                            <span class="material-symbols-outlined">check_circle</span>
                            Approve
                        </button>
                    </div>
                </div>
            </div>

            {{-- TEST CARDS --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-primary">4. Cards & Alerts</h2>

                    <div class="grid md:grid-cols-2 gap-6 mt-4">
                        {{-- Card dengan border --}}
                        <div class="card border border-primary/20">
                            <div class="card-body">
                                <h3 class="card-title">Card with border</h3>
                                <p>Border dengan opacity primary</p>
                            </div>
                        </div>

                        {{-- Card dengan shadow --}}
                        <div class="card shadow-lg shadow-primary/10">
                            <div class="card-body">
                                <h3 class="card-title">Card with shadow</h3>
                                <p>Shadow dengan warna primary</p>
                            </div>
                        </div>
                    </div>

                    {{-- Alerts --}}
                    <div class="space-y-4 mt-6">
                        <div class="alert alert-info">
                            <span class="material-symbols-outlined">info</span>
                            <span>Info alert</span>
                        </div>
                        <div class="alert alert-success">
                            <span class="material-symbols-outlined">check_circle</span>
                            <span>Success alert</span>
                        </div>
                        <div class="alert alert-warning">
                            <span class="material-symbols-outlined">warning</span>
                            <span>Warning alert</span>
                        </div>
                        <div class="alert alert-error">
                            <span class="material-symbols-outlined">error</span>
                            <span>Error alert</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TEST FORM ELEMENTS --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-primary">5. Form Elements</h2>

                    <div class="grid md:grid-cols-2 gap-6 mt-4">
                        {{-- Input --}}
                        <div>
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Text Input</span>
                                </div>
                                <input type="text" placeholder="Type here" class="input input-bordered w-full" />
                            </label>
                        </div>

                        {{-- Select --}}
                        <div>
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Select</span>
                                </div>
                                <select class="select select-bordered w-full">
                                    <option>Pilih Jurusan</option>
                                    <option>TKJ</option>
                                    <option>AKL</option>
                                    <option>BDP</option>
                                    <option>MM</option>
                                </select>
                            </label>
                        </div>

                        {{-- Checkbox --}}
                        <div>
                            <div class="form-control">
                                <label class="label cursor-pointer">
                                    <span class="label-text">Remember me</span>
                                    <input type="checkbox" checked="checked" class="checkbox checkbox-primary" />
                                </label>
                            </div>
                        </div>

                        {{-- Radio --}}
                        <div>
                            <div class="form-control">
                                <label class="label cursor-pointer">
                                    <span class="label-text">Laki-laki</span>
                                    <input type="radio" name="radio" class="radio radio-primary" checked />
                                </label>
                            </div>
                            <div class="form-control">
                                <label class="label cursor-pointer">
                                    <span class="label-text">Perempuan</span>
                                    <input type="radio" name="radio" class="radio radio-primary" />
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TEST MATERIAL ICONS --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-primary">6. Material Icons</h2>

                    <div class="flex flex-wrap gap-4 text-4xl text-primary">
                        <span class="material-symbols-outlined">home</span>
                        <span class="material-symbols-outlined">school</span>
                        <span class="material-symbols-outlined">person</span>
                        <span class="material-symbols-outlined">settings</span>
                        <span class="material-symbols-outlined">favorite</span>
                        <span class="material-symbols-outlined">star</span>
                        <span class="material-symbols-outlined">search</span>
                        <span class="material-symbols-outlined">menu</span>
                        <span class="material-symbols-outlined">close</span>
                        <span class="material-symbols-outlined">check</span>
                    </div>
                    <div class="flex flex-wrap gap-4 text-2xl text-secondary mt-2">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                        <span class="material-symbols-outlined">upload</span>
                        <span class="material-symbols-outlined">download</span>
                        <span class="material-symbols-outlined">print</span>
                        <span class="material-symbols-outlined">share</span>
                    </div>
                </div>
            </div>

            {{-- TEST RESPONSIVE --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-primary">7. Responsive Test</h2>
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl xl:text-2xl">
                        Resize browser untuk melihat perubahan ukuran text
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
                        <div class="bg-primary/20 p-4 rounded">Col 1</div>
                        <div class="bg-primary/20 p-4 rounded">Col 2</div>
                        <div class="bg-primary/20 p-4 rounded">Col 3</div>
                        <div class="bg-primary/20 p-4 rounded">Col 4</div>
                    </div>
                </div>
            </div>

            {{-- FINAL RESULT --}}
            <div class="alert alert-success shadow-lg">
                <span class="material-symbols-outlined">check_circle</span>
                <span class="font-bold">Semua test di atas harus tampil dengan style yang benar!</span>
            </div>

        </div>
    </div>
@endsection