<aside class="bg-gradient-to-b from-slate-900 to-blue-950 border-r border-slate-700/50 w-[240px] flex flex-col justify-between py-5 px-4 shadow-xl shrink-0">
    <div>
        <div class="pb-5 mb-2 border-b border-slate-700/50">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-store text-sm text-white"></i>
                </div>
                <h1 class="text-white font-bold text-[16px] tracking-tight">Point of Sale</h1>
            </div>
        </div>

        @php
            $user = Session::get('user');

            $user->role->role_id == \App\Models\Role::ROLE_ADMIN
                ? ($menus = [
                    [
                        'group' => 'Menu Utama',
                        'menus' => [
                            [
                                'routeUrl' => route('dashboard'),
                                'routePattern' => 'dashboard',
                                'navIcon' => 'fa-solid fa-layer-group',
                                'navTitle' => 'Dashboard',
                            ],
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
                            [
                                'routeUrl' => route('supplier-stock.index'),
                                'routePattern' => 'supplier-stock.*',
                                'navIcon' => 'fa-solid fa-user-group',
                                'navTitle' => 'Supplier Barang',
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
                        ],
                    ],
                    [
                        'group' => 'Menu Lainnya',
                        'menus' => [
                            [
                                'routeUrl' => route('category.index'),
                                'routePattern' => [
                                    'category.*',
                                    'customer-category.*',
                                    'rack.*',
                                    'region.*',
                                    'user.*',
                                    'store.*',
                                ],
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
                <div class="py-1 pt-3">
                    <span class="uppercase text-[10px] font-semibold tracking-wider text-blue-300/60">
                        {{ $menu['group'] }}
                    </span>
                </div>
                @foreach ($menu['menus'] as $item)
                    @php
                        $navActiveClass = request()->routeIs($item['routePattern'])
                            ? 'bg-slate-800 text-white shadow-md shadow-slate-800/20'
                            : 'text-slate-300 hover:bg-white/10 hover:text-white';
                    @endphp

                    <li>
                        <a href="{{ $item['routeUrl'] }}">
                            <div
                                class="flex items-center gap-3 rounded-lg py-2 px-3 outline-none font-medium text-[13px] tracking-wide transition-all duration-200 {{ $navActiveClass }}">
                                <div class="w-4 h-4 flex items-center justify-center">
                                    <i class="{{ $item['navIcon'] }} text-[13px]"></i>
                                </div>
                                <span>{{ $item['navTitle'] }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>

    <form id="form-logout" action="{{ route('logout') }}" method="POST">
        @csrf

        <button id="logout-button"
            class="flex items-center gap-3 rounded-lg py-2.5 px-3 w-full text-sm text-slate-300 border border-slate-700/50 transition-all duration-200 hover:bg-red-500/10 hover:text-red-400 hover:border-red-500/30 cursor-pointer">
            <div class="w-4 h-4 flex items-center justify-center">
                <i class="fa-solid fa-right-from-bracket text-[13px]"></i>
            </div>
            <span class="tracking-wide">Keluar</span>
        </button>
    </form>
</aside>
