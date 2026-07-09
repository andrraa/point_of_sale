<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Point of Sale')</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    @vite(['resources/css/app.css'])
    @stack('styles')
</head>

<body>
    <div class="h-dvh overflow-hidden bg-slate-50 flex">
        @include('partials.sidebar')

        <div class="h-full overflow-hidden w-full flex flex-col">
            @include('partials.navbar')

            <main class="overflow-y-auto max-w-full px-6 py-4 flex-1 min-h-0">
                @yield('content')
            </main>
        </div>
    </div>

    @vite(['resources/js/app.js'])

    <script type="module">
        $(document).ready(function() {
            // AJAX SETUP
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // SELETCT2
            $('.select2').select2({
                placeholder: 'Pilih salah satu opsi',
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
