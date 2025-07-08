<nav class="max-w-screen w-full flex items-center justify-between h-18 px-6">
    <div>
        <h1 class="font-bold tracking-wide text-lg text-blue-500">@yield('navTitle')</h1>
    </div>

    <div
        class="bg-white shadow-lg border border-gray-200 flex items-center gap-2 rounded-full py-1 px-2 border-gray-200">
        <div class="bg-blue-500 w-6 h-6 flex items-center justify-center rounded-full">
            <i class="fa-solid fa-user text-white"></i>
        </div>

        <div>
            <h1 class="text-sm font-medium tracking-wider text-blue-500 capitalize">
                {{ Session::get('user')['full_name'] }}
            </h1>
        </div>
    </div>
</nav>
