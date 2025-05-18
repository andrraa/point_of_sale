<div class="mb-4">
    <x-form.label :props="[
        'for' => 'purchase_invoice',
        'label' => 'Bukti / Faktur Beli',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'purchase_invoice',
        'name' => 'purchase_invoice',
        'placeholder' => 'Faktu Beli',
        'value' => old('purchase_invoice', $purchase->purchase_invoice ?? null),
    ]" />
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'purchase_supplier_id',
            'label' => 'Pemasok / Supplier',
            'required' => true,
        ]" />

        <x-form.select :props="[
            'id' => 'purchase_supplier_id',
            'name' => 'purchase_supplier_id',
            'value' => old('purchase_supplier_id', $purchase->purchase_supplier_id ?? null),
            'class' => 'w-full',
        ]" :options="$suppliers" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'purchase_area',
            'label' => 'Wilayah',
            'required' => true,
        ]" />

        <x-form.select :props="[
            'id' => 'purchase_region_id',
            'name' => 'purchase_region_id',
            'value' => old('purchase_region_id', $purchase->purchase_region_id ?? null),
            'class' => 'w-full',
        ]" :options="$regions" />
    </div>
</div>

<div class="mb-4">
    <x-form.label :props="[
        'for' => 'purchase_note',
        'label' => 'Keterangan',
    ]" />

    <x-form.input :props="[
        'id' => 'purchase_note',
        'name' => 'purchase_note',
        'placeholder' => 'Keterangan',
        'value' => old('purchase_note', $purchase->purchase_note ?? null),
    ]" />
</div>

<div class="h-0.5 bg-gray-200 mt-4 mb-4"></div>

{{-- ITEMS --}}
<div class="mb-4">
    <h1 class="font-medium tracking-wide text-blue-900">Tambahkan Data Barang</h1>
</div>

<div class="grid grid-cols-3 gap-4 mb-4">
    <div>
        <x-form.select :props="[
            'id' => 'item',
            'name' => 'item',
            'class' => 'w-full',
            'value' => null,
        ]" :options="$stocks" />
    </div>

    <div>
        <x-form.input :props="[
            'id' => 'quantity',
            'name' => 'quantity',
            'class' => 'number-input',
            'placeholder' => 'Masukkan Jumlah Barang (PCS)',
        ]" />
    </div>

    <div>
        <button type="button" id="item-button"
            class="px-4 py-[10px] border border-blue-900 rounded-md cursor-pointer text-blue-900 bg-white hover:bg-blue-900 hover:text-white font-medium transition duration-200">
            Tambah Barang
        </button>
    </div>
</div>
