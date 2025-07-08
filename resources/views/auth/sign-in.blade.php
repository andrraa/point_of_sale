<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk Akun</title>

    @vite(['resources/css/app.css'])
</head>

<body>
    <section class="min-h-dvh flex flex-col bg-slate-100">
        <main class="flex-1 flex items-center justify-center">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4 w-[380px]">
                <div class="mb-4 pb-2 border-b border-b-gray-200">
                    <h1 class="text-lg font-bold text-blue-500 traking-wide">Masuk Akun</h1>
                </div>

                <form id="form-sign-in" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-2">
                        <x-form.label :props="[
                            'for' => 'username',
                            'label' => 'nama pengguna',
                            'required' => true,
                        ]" />

                        <x-form.input :props="[
                            'id' => 'username',
                            'name' => 'username',
                            'placeholder' => 'Masukkan nama pengguna',
                        ]" />
                    </div>

                    <div class="mb-6">
                        <x-form.label :props="[
                            'for' => 'password',
                            'label' => 'kata sandi',
                            'required' => true,
                        ]" />

                        <x-form.input :props="[
                            'type' => 'password',
                            'id' => 'password',
                            'name' => 'password',
                            'placeholder' => 'Masukkan kata sandi',
                        ]" />
                    </div>

                    <x-form.submit :props="[
                        'id' => 'sign-in-button',
                        'label' => 'Masuk',
                    ]" />
                </form>
            </div>
        </main>

        <footer class="text-center py-4">
            <h1 class="text-gray-500 tracking-wide">Copyright &copy; 2025 Point of Sale</h1>
        </footer>
    </section>

    @vite(['resources/js/app.js'])

    <script type="module" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script type="module">
        {!! $validator !!}
    </script>
</body>

</html>
