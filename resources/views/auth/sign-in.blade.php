<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk Akun</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    @vite(['resources/css/app.css'])
</head>

<body>
    <div class="min-h-dvh flex">
        {{-- LEFT BRAND PANEL --}}
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute top-1/4 -right-20 w-[400px] h-[400px] bg-slate-500/10 rounded-full blur-[100px]"></div>
                <div class="absolute -bottom-20 -left-20 w-[300px] h-[300px] bg-indigo-500/10 rounded-full blur-[100px]"></div>
            </div>

            <div class="relative text-center px-12">
                <div class="w-20 h-20 mx-auto mb-6 bg-white/10 backdrop-blur rounded-2xl flex items-center justify-center ring-1 ring-white/20">
                    <i class="fa-solid fa-store text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Point of Sale</h1>
                <p class="text-blue-200/60 mt-3 text-sm tracking-wide">Sistem manajemen bisnis terintegrasi</p>
            </div>
        </div>

        {{-- RIGHT FORM PANEL --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center bg-gradient-to-br from-slate-50 to-white p-6">
            <div class="w-full max-w-sm">
                {{-- MOBILE HEADER --}}
                <div class="lg:hidden text-center mb-8">
                    <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-store text-lg text-white"></i>
                    </div>
                    <h1 class="text-xl font-bold text-slate-800">Point of Sale</h1>
                    <p class="text-xs text-slate-500 mt-1">Masuk ke akun Anda</p>
                </div>

                <div class="bg-white rounded-2xl shadow-[0_4px_24px_-4px_rgba(0,0,0,0.08)] border border-slate-200 p-8">
                    <div class="hidden lg:block mb-8">
                        <h2 class="text-xl font-semibold text-slate-800">Selamat Datang</h2>
                        <p class="text-sm text-slate-500 mt-1">Silakan masuk ke akun Anda</p>
                    </div>

                    <form id="form-sign-in" action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-5">
                            <label for="username" class="block text-sm font-medium text-slate-700 mb-1.5">
                                Nama Pengguna <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-0 pl-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                    <i class="fa-solid fa-user text-sm"></i>
                                </span>
                                <input type="text" id="username" name="username"
                                    class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 outline-none transition-all focus:border-slate-800 focus:ring-2 focus:ring-slate-800/20"
                                    placeholder="Masukkan nama pengguna" autofocus autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                                Kata Sandi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-0 pl-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </span>
                                <input type="password" id="password" name="password"
                                    class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 outline-none transition-all focus:border-slate-800 focus:ring-2 focus:ring-slate-800/20"
                                    placeholder="Masukkan kata sandi">
                            </div>
                        </div>

                        <button type="submit" id="sign-in-button"
                            class="w-full py-2.5 px-4 bg-gradient-to-r from-slate-800 to-slate-900 hover:from-slate-900 hover:to-slate-950 text-white text-sm font-semibold rounded-lg shadow-lg shadow-slate-800/20 hover:shadow-slate-800/30 transition-all duration-200 cursor-pointer outline-none">
                            Masuk
                        </button>
                    </form>
                </div>

                <p class="text-center mt-8 text-xs text-slate-400 tracking-wide">&copy; {{ date('Y') }} Point of Sale. All rights reserved.</p>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])

    <script type="module" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script type="module">
        {!! $validator !!}
    </script>
</body>

</html>
