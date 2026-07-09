<aside class="bg-white border border-slate-200 w-[200px] rounded-xl flex flex-col p-3 shadow-sm shrink-0">
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
                'routeUrl' => route('rack.index'),
                'routePattern' => 'rack.*',
                'menuIcon' => 'fa-solid fa-box',
                'menuTitle' => 'Rak',
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
                    ? 'text-slate-800 font-semibold bg-slate-100'
                    : 'text-slate-500 hover:bg-slate-50';
            @endphp
            <li>
                <a href="{{ $menu['routeUrl'] }}">
                    <div
                        class="flex items-center gap-2 p-2.5 outline-none text-xs rounded-lg tracking-wide transition-all duration-200 {{ $navActiveClass }}">
                        <div class="h-4 w-4 flex items-center justify-center">
                            <i class="{{ $menu['menuIcon'] }} text-[13px]"></i>
                        </div>
                        <span>{{ $menu['menuTitle'] }}</span>
                    </div>
                </a>
            </li>

            @if (!$loop->last)
                <div class="h-px bg-slate-100 my-1.5"></div>
            @endif
        @endforeach
    </ul>
</aside>
