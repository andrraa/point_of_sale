<aside class="bg-white border-r border-r-gray-200 w-[280px] flex flex-col justify-between py-5 px-4">
    <div>
        <div class="pb-4">
            <h1 class="text-blue-900 font-bold text-[18px]">Point of Sale</h1>
        </div>

        {{-- Menu --}}
        @php
            $menus = [
                [
                    'routeUrl' => route('dashboard'),
                    'routePattern' => 'dashboard',
                    'navIcon' => 'fa-solid fa-home',
                    'navTitle' => 'Dashboard',
                ],
                [
                    'routeUrl' => '',
                    'routePattern' => 'point-of-sale',
                    'navIcon' => 'fa-solid fa-laptop',
                    'navTitle' => 'POS',
                ],
                [
                    'routeUrl' => '',
                    'routePattern' => 'customer',
                    'navIcon' => 'fa-solid fa-user-tag',
                    'navTitle' => 'Pelanggan',
                ],
                [
                    'routeUrl' => '',
                    'routePattern' => 'supplier',
                    'navIcon' => 'fa-solid fa-dolly',
                    'navTitle' => 'Pemasok',
                ],
                [
                    'routeUrl' => '',
                    'routePattern' => 'report',
                    'navIcon' => 'fa-solid fa-file-lines',
                    'navTitle' => 'Laporan',
                ],
                [
                    'routeUrl' => route('category.index'),
                    'routePattern' => ['category.*', 'subcategory.*', 'user.*'],
                    'navIcon' => 'fa-solid fa-gear',
                    'navTitle' => 'Pengaturan',
                ],
            ];
        @endphp
        <ul class="space-y-1">
            @foreach ($menus as $menu)
                @php
                    $navActiveClass = request()->routeIs($menu['routePattern'])
                        ? 'bg-blue-900 text-white'
                        : 'hover:bg-blue-900/20 text-gray-600';
                @endphp

                <li>
                    <a href="{{ $menu['routeUrl'] }}">
                        <div class="flex items-center gap-3 rounded-lg py-2 px-4 outline-none {{ $navActiveClass }}">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <i class="{{ $menu['navIcon'] }} text-sm"></i>
                            </div>
                            <div class="mt-auto">
                                <span class="text-sm tracking-wider">{{ $menu['navTitle'] }}</span>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Logout --}}
    <div id="logout-button"
        class="flex items-center gap-3 rounded-lg py-2 px-4 border border-red-500 text-red-500 transition duraiton-200 hover:bg-red-500 hover:text-white hover:font-medium cursor-pointer">
        <div class="w-4 h-4 flex items-center justify-center">
            <i class="fa-solid fa-right-from-bracket text-sm"></i>
        </div>
        <div class="mt-auto">
            <span class="text-sm tracking-wider">Sign Out</span>
        </div>
    </div>
</aside>
