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
            <div class="bg-white rounded-lg border border-gray-200 shadow-lg p-4 w-[380px]">
                <div class="mb-4 pb-2 border-b border-b-gray-200">
                    <h1 class="text-lg font-medium">Masuk Akun</h1>
                </div>

                <form action="">
                    @csrf

                    <div class="mb-2">
                        <x-form.label />

                        <x-form.input />
                    </div>

                    <div class="mb-6">
                        <x-form.label />

                        <x-form.input />
                    </div>

                    <x-form.submit :props="[
                        'label' => 'Masuk',
                    ]" />
                </form>
            </div>
        </main>

        <footer class="text-center py-4">
            <h1 class="text-gray-500 tracking-wide">&copy; 2025 Point of Sale</h1>
        </footer>
    </section>


    @vite(['resources/js/app.js'])
</body>

</html>
