<div class="grid grid-cols-2 gap-5 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'stock_code',
            'label' => 'Kode',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.input :props="[
            'id' => 'stock_code',
            'name' => 'stock_code',
            'placeholder' => 'Kode Stok Barang',
            'value' => old('stock_code', $stock->stock_code ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'stock_name',
            'label' => 'Nama Barang',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.input :props="[
            'id' => 'stock_name',
            'name' => 'stock_name',
            'placeholder' => 'Nama Stok Barang',
            'value' => old('stock_name', $stock->stock_name ?? null),
        ]" />
    </div>
</div>

<div class="grid grid-cols-3 gap-5 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'stock_category_id',
            'label' => 'Kategori',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.select :props="[
            'id' => 'stock_category_id',
            'name' => 'stock_category_id',
            'value' => old('stock_category_id', $stock->stock_category_id ?? null),
            'class' => 'w-full',
        ]" :options="$categories" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'stock_rack_id',
            'label' => 'Rak',
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.select :props="[
            'id' => 'stock_rack_id',
            'name' => 'stock_rack_id',
            'value' => old('stock_rack_id', $stock->stock_rack_id ?? null),
            'class' => 'w-full',
        ]" :options="$racks" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'stock_unit',
            'label' => 'Unit',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.input :props="[
            'id' => 'stock_unit',
            'name' => 'stock_unit',
            'placeholder' => 'Stok Unit',
            'readonly' => true,
            'value' => 'PCS',
        ]" />
    </div>
</div>

<div class="mb-4">
    <x-form.label :props="[
        'for' => 'stock_purchase_price',
        'label' => 'Harga Pokok / Harga Beli',
        'required' => true,
        'class' => 'text-slate-700 font-medium text-sm',
    ]" />

    <x-form.input :props="[
        'id' => 'stock_purchase_price',
        'name' => 'stock_purchase_price',
        'class' => 'price-input',
        'placeholder' => 'Masukkan Harga Pokok / Harga Beli',
        'value' => old('stock_purchase_price', $stock->stock_purchase_price ?? 0),
    ]" />
</div>

<div class="grid grid-cols-3 gap-5 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'stock_sale_price_1',
            'label' => 'Harga Jual 1 (Umum)',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.input :props="[
            'id' => 'stock_sale_price_1',
            'name' => 'stock_sale_price_1',
            'class' => 'price-input',
            'placeholder' => 'Masukkan Harga Jual 1',
            'value' => old('stock_sale_price_1', $stock->stock_sale_price_1 ?? 0),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'stock_sale_price_2',
            'label' => 'Harga Jual 2 (Grosir)',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.input :props="[
            'id' => 'stock_sale_price_2',
            'name' => 'stock_sale_price_2',
            'class' => 'price-input',
            'placeholder' => 'Masukkan Harga Jual 2',
            'value' => old('stock_sale_price_2', $stock->stock_sale_price_2 ?? 0),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'stock_sale_price_3',
            'label' => 'Harga Jual 3 (Gudang)',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.input :props="[
            'id' => 'stock_sale_price_3',
            'name' => 'stock_sale_price_3',
            'class' => 'price-input',
            'placeholder' => 'Masukkan Harga Jual 3',
            'value' => old('stock_sale_price_3', $stock->stock_sale_price_3 ?? 0),
        ]" />
    </div>
</div>

<div class="mb-4">
    <x-form.label :props="[
        'for' => 'stock_ss_id',
        'label' => 'Supplier',
        'class' => 'text-slate-700 font-medium text-sm',
    ]" />

    <x-form.select :props="[
        'id' => 'stock_ss_id',
        'name' => 'stock_ss_id',
        'value' => old('stock_ss_id', $stock->stock_ss_id ?? null),
        'class' => 'w-full',
    ]" :options="$suppliers" />
</div>

<div class="h-px bg-slate-200 w-full my-6"></div>

<div class="mb-4 w-fit">
    <x-form.check :props="[
        'id' => 'stock-edit',
        'name' => 'stock-edit',
    ]" />
</div>

<div class="grid grid-cols-4 gap-5 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'stock_total',
            'label' => 'Stok Total',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.input :props="[
            'id' => 'stock_total',
            'name' => 'stock_total',
            'class' => 'number-input',
            'placeholder' => 'Masukkan stok total',
            'value' => old('stock_total', $stock->stock_total ?? 0),
            'readonly' => true,
        ]" />
    </div>
</div>
