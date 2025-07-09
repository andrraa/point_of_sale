<aside class="bg-white border border-gray-200 w-[200px] rounded-lg flex flex-col p-3 shadow-lg">
    @php
        $menuItems = [
            [
                'routeUrl' => route('category.index'),
                'routePattern' => 'category.*',
                'menuIcon' => 'fa-solid fa-list',
                'menuTitle' => 'Kategori Barang',
            ],
            [
                'routeUrl' => route('customer-category.index'),
                'routePattern' => 'customer-category.*',
                'menuIcon' => 'fa-solid fa-list',
                'menuTitle' => 'Kategori Pelanggan',
            ],
            [
                'routeUrl' => route('region.index'),
                'routePattern' => 'region.*',
                'menuIcon' => 'fa-solid fa-location-dot',
                'menuTitle' => 'Wilayah',
            ],
            [
                'routeUrl' => route('user.index'),
                'routePattern' => 'user.*',
                'menuIcon' => 'fa-regular fa-user',
                'menuTitle' => 'Pengguna',
            ],
            [
                'routeUrl' => route('store.index'),
                'routePattern' => 'store.*',
                'menuIcon' => 'fa-solid fa-store',
                'menuTitle' => 'Informasi Toko',
            ],
        ];
    @endphp
    <ul>
        @foreach ($menuItems as $menu)
            @php
                $navActiveClass = request()->routeIs($menu['routePattern'])
                    ? 'text-blue-500 font-bold'
                    : 'text-gray-500 hover:bg-blue-500/5';
            @endphp
            <li>
                <a href="{{ $menu['routeUrl'] }}">
                    <div
                        class="flex items-center gap-2 p-3 outline-none text-xs rounded-lg text-center tracking-wider {{ $navActiveClass }}">
                        <div class="h-4 w-4 flex items-center justify-center">
                            <i class="{{ $menu['menuIcon'] }} text-[13px]"></i>
                        </div>
                        <h1>{{ $menu['menuTitle'] }}</h1>
                    </div>
                </a>
            </li>

            @if (!$loop->last)
                <div class="h-[1px] bg-gray-200 mt-2 mb-2"></div>
            @endif
        @endforeach
    </ul>
</aside>
