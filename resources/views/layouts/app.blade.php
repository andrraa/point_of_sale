<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Point of Sale')</title>

    @vite(['resources/css/app.css'])
    @stack('styles')
</head>

<body>
    <div class="h-dvh overflow-hidden bg-gray-100 flex">
        @include('partials.sidebar')

        <div class="h-dvh overflow-hidden w-full">
            @include('partials.navbar')

            <main class="h-full overflow-y-auto max-w-full">
                @yield('content')
            </main>
        </div>
    </div>

    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>

</html>
