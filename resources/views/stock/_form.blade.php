<div class="mb-2">
    <x-form.label :props="[
        'for' => 'stock_code',
        'label' => 'Kode',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'stock_code',
        'name' => 'stock_code',
        'placeholder' => 'Kode Stok Barang',
        'value' => old('stock_code', $stock->stock_code ?? null),
    ]" />
</div>

<div class="mb-2">
    <x-form.label :props="[
        'for' => 'stock_name',
        'label' => 'Nama Barang',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'stock_name',
        'name' => 'stock_name',
        'placeholder' => 'Nama Stok Barang',
        'value' => old('stock_name', $stock->stock_name ?? null),
    ]" />
</div>

<div class="mb-2">
    <x-form.label :props="[
        'for' => 'stock_category_id',
        'label' => 'Stok Kategory',
        'required' => true,
    ]" />

    <x-form.select :props="[
        'id' => 'stock_category_id',
        'name' => 'stock_category_id',
        'value' => old('stock_category_id', $stock->stock_category_id ?? null),
        'class' => 'w-full',
    ]" :options="$categories" />
</div>

<div class="mb-2">
    <x-form.label :props="[
        'for' => 'stock_unit',
        'label' => 'Stok Unit',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'stock_unit',
        'name' => 'stock_unit',
        'placeholder' => 'Stok Unit',
        'readonly' => true,
        'value' => 'PCS',
    ]" />
</div>

<div class="mb-2">
    <x-form.label :props="[
        'for' => 'stock_purchase_price',
        'label' => 'Harga Pokok / Harga Beli',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'stock_purchase_price',
        'name' => 'stock_purchase_price',
        'class' => 'price-input',
        'placeholder' => 'Masukkan Harga Pokok / Harga Beli',
        'value' => old('stock_purchase_price', $stock->stock_purchase_price ?? 0),
    ]" />
</div>

<div class="mb-2">
    <x-form.label :props="[
        'for' => 'stock_sale_price_1',
        'label' => 'Harga Jual 1',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'stock_sale_price_1',
        'name' => 'stock_sale_price_1',
        'class' => 'price-input',
        'placeholder' => 'Masukkan Harga Jual 1',
        'value' => old('stock_sale_price_1', $stock->stock_sale_price_1 ?? 0),
    ]" />
</div>

<div class="mb-2">
    <x-form.label :props="[
        'for' => 'stock_sale_price_2',
        'label' => 'Harga Jual 2',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'stock_sale_price_2',
        'name' => 'stock_sale_price_2',
        'class' => 'price-input',
        'placeholder' => 'Masukkan Harga Jual 2',
        'value' => old('stock_sale_price_2', $stock->stock_sale_price_2 ?? 0),
    ]" />
</div>

<div class="mb-2">
    <x-form.label :props="[
        'for' => 'stock_sale_price_3',
        'label' => 'Harga Jual 3',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'stock_sale_price_3',
        'name' => 'stock_sale_price_3',
        'class' => 'price-input',
        'placeholder' => 'Masukkan Harga Jual 3',
        'value' => old('stock_sale_price_3', $stock->stock_sale_price_3 ?? 0),
    ]" />
</div>

<div class="mb-2">
    <x-form.label :props="[
        'for' => 'stock_sale_price_4',
        'label' => 'Harga Jual 4',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'stock_sale_price_4',
        'name' => 'stock_sale_price_4',
        'class' => 'price-input',
        'placeholder' => 'Masukkan Harga Jual 4',
        'value' => old('stock_sale_price_4', $stock->stock_sale_price_4 ?? 0),
    ]" />
</div>
