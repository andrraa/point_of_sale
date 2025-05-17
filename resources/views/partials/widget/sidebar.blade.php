<aside class="bg-white border border-gray-200 w-[100px] rounded-lg flex flex-col p-2">
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
        ];
    @endphp
    <ul>
        @foreach ($menuItems as $menu)
            @php
                $navActiveClass = request()->routeIs($menu['routePattern'])
                    ? 'text-blue-900 font-semibold'
                    : 'text-gray-400 hover:bg-blue-900/5';
            @endphp
            <li>
                <a href="{{ $menu['routeUrl'] }}">
                    <div
                        class="flex flex-col items-center justify-center gap-1 p-2 outline-none text-xs rounded-lg text-center tracking-wider {{ $navActiveClass }}">
                        <div>
                            <i class="{{ $menu['menuIcon'] }} text-sm"></i>
                        </div>
                        <h1>{{ $menu['menuTitle'] }}</h1>
                    </div>
                </a>
            </li>

            @if (!$loop->last)
                <div class="h-[1px] bg-gray-200 mt-1 mb-1"></div>
            @endif
        @endforeach
    </ul>
</aside>
