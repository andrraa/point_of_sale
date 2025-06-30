<aside class="bg-white border-r border-r-gray-200 w-[240px] flex flex-col justify-between py-5 px-4">
    <div>
        <div class="pb-4">
            <h1 class="text-blue-900 font-bold text-[18px]">Point of Sale</h1>
        </div>

        {{-- Menu --}}
        @php
            $user = Session::get('user');

            $user->role->role_id == \App\Models\Role::ROLE_ADMIN
                ? ($menus = [
                    [
                        'group' => 'Menu Utama',
                        'menus' => [
                            [
                                'routeUrl' => route('cashier'),
                                'routePattern' => 'cashier',
                                'navIcon' => 'fa-solid fa-laptop',
                                'navTitle' => 'Kasir POS',
                            ],
                        ],
                    ],
                    [
                        'group' => 'Data Utama',
                        'menus' => [
                            [
                                'routeUrl' => route('customer.index'),
                                'routePattern' => 'customer.*',
                                'navIcon' => 'fa-solid fa-user-tag',
                                'navTitle' => 'Pelanggan',
                            ],
                            [
                                'routeUrl' => route('supplier.index'),
                                'routePattern' => 'supplier.*',
                                'navIcon' => 'fa-solid fa-dolly',
                                'navTitle' => 'Pemasok',
                            ],
                            [
                                'routeUrl' => route('stock.index'),
                                'routePattern' => 'stock.*',
                                'navIcon' => 'fa-solid fa-boxes-stacked',
                                'navTitle' => 'Stok Barang',
                            ],
                        ],
                    ],
                    [
                        'group' => 'Akutansi & Laporan',
                        'menus' => [
                            [
                                'routeUrl' => route('purchase.index'),
                                'routePattern' => 'purchase.*',
                                'navIcon' => 'fa-solid fa-basket-shopping',
                                'navTitle' => 'Pembelian',
                            ],
                            [
                                'routeUrl' => route('sale.index'),
                                'routePattern' => 'sale.*',
                                'navIcon' => 'fa-solid fa-truck-ramp-box',
                                'navTitle' => 'Penjualan',
                            ],
                            [
                                'routeUrl' => route('report'),
                                'routePattern' => 'report',
                                'navIcon' => 'fa-solid fa-file-lines',
                                'navTitle' => 'Laporan',
                            ],
                        ],
                    ],
                    [
                        'group' => 'Menu Lainnya',
                        'menus' => [
                            [
                                'routeUrl' => route('category.index'),
                                'routePattern' => ['category.*', 'customer-category.*', 'region.*', 'user.*'],
                                'navIcon' => 'fa-solid fa-gear',
                                'navTitle' => 'Pengaturan',
                            ],
                        ],
                    ],
                ])
                : ($menus = [
                    [
                        'group' => 'Menu Utama',
                        'menus' => [
                            [
                                'routeUrl' => route('cashier'),
                                'routePattern' => 'cashier',
                                'navIcon' => 'fa-solid fa-laptop',
                                'navTitle' => 'Kasir POS',
                            ],
                        ],
                    ],
                ]);
        @endphp
        <ul class="space-y-1">
            @foreach ($menus as $menu)
                <div class="py-1">
                    <span class="uppercase text-[10px] font-medium tracking-wide text-gray-400">
                        {{ $menu['group'] }}
                    </span>
                </div>
                @foreach ($menu['menus'] as $item)
                    @php
                        $navActiveClass = request()->routeIs($item['routePattern'])
                            ? 'bg-blue-900 text-white'
                            : 'hover:bg-blue-900/20 text-gray-500';
                    @endphp

                    <li>
                        <a href="{{ $item['routeUrl'] }}">
                            <div
                                class="flex items-center gap-3 rounded-lg py-2 px-3 outline-none font-medium {{ $navActiveClass }}">
                                <div class="w-4 h-4 flex items-center justify-center">
                                    <i class="{{ $item['navIcon'] }} text-[13px]"></i>
                                </div>
                                <span class="text-[13px] tracking-wide">{{ $item['navTitle'] }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>

    {{-- Logout --}}
    <form id="form-logout" action="{{ route('logout') }}" method="POST">
        @csrf

        <button id="logout-button"
            class="flex items-center gap-3 rounded-lg py-2 px-3 border border-red-500 text-red-500 transition duraiton-200 hover:bg-red-500 hover:text-white hover:font-medium cursor-pointer w-full">
            <div class="w-4 h-4 flex items-center justify-center">
                <i class="fa-solid fa-right-from-bracket text-[13px]"></i>
            </div>
            <span class="text-[13px] tracking-wider">Keluar</span>
        </button>
    </form>
</aside>
