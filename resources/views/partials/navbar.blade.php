<nav class="max-w-screen w-full flex items-center justify-between h-18 px-6 border-b border-slate-200 bg-white">
    <div>
        <h1 class="font-bold tracking-wide text-lg text-slate-800">@yield('navTitle')</h1>
    </div>

    <div class="flex items-center gap-3 bg-slate-50 border border-slate-200 rounded-full py-1.5 pl-1.5 pr-4 shadow-sm">
        <div class="bg-gradient-to-br from-slate-700 to-slate-900 w-7 h-7 flex items-center justify-center rounded-full">
            <i class="fa-solid fa-user text-[11px] text-white"></i>
        </div>

        <div>
            <h1 class="text-sm font-medium text-slate-700 capitalize">
                {{ Session::get('user')['full_name'] }}
            </h1>
        </div>
    </div>
</nav>
