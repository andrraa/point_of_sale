<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Point of Sale')</title>

    @vite(['resources/css/app.css'])
    @stack('styles')
</head>

<body>
    <div class="h-dvh overflow-hidden bg-gray-100 flex">
        @include('partials.sidebar')

        <div class="h-full overflow-hidden w-full flex flex-col">
            @include('partials.navbar')

            <main class="overflow-y-auto max-w-full px-6 pb-4 flex-l h-full">
                @yield('content')
            </main>
        </div>
    </div>

    @vite(['resources/js/app.js'])

    <script type="module">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // SELETCt2
            $('.select2').select2({
                placeholder: '------ Pilih ------',
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
