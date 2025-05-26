<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'supplier_code',
            'label' => 'Kode Pemasok',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_code',
            'name' => 'supplier_code',
            'placeholder' => 'Kode Pemasok. Contoh: 000',
            'value' => old('supplier_code', $supplier->supplier_code ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'supplier_name',
            'label' => 'Nama Pemasok',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_name',
            'name' => 'supplier_name',
            'placeholder' => 'Nama Pemasok. Contoh: Rudi',
            'value' => old('supplier_name', $supplier->supplier_name ?? null),
        ]" />
    </div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'supplier_address',
            'label' => 'Alamat Pemasok',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_address',
            'name' => 'supplier_address',
            'placeholder' => 'Alamat Pemasok. Contoh: Jakarta',
            'value' => old('supplier_address', $supplier->supplier_address ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'supplier_region_id',
            'label' => 'Wilayah Pemasok',
            'required' => true,
        ]" />

        <x-form.select :props="[
            'id' => 'supplier_region_id',
            'name' => 'supplier_region_id',
            'value' => old('supplier_region_id', $supplier->supplier_region_id ?? null),
            'class' => 'w-full',
        ]" :options="$regions" />
    </div>
</div>

<div class="mb-4">
    <x-form.label :props="[
        'for' => 'supplier_contact_person',
        'label' => 'Orang Yang Dapat Dihubungi',
    ]" />

    <x-form.input :props="[
        'id' => 'supplier_contact_person',
        'name' => 'supplier_contact_person',
        'placeholder' => 'Masukkan orang yang dapat dihubungi',
        'value' => old('supplier_contact_person', $supplier->supplier_contact_person ?? null),
    ]" />
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'supplier_telepon_number',
            'label' => 'Nomor Telepon',
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_telepon_number',
            'name' => 'supplier_telepon_number',
            'placeholder' => 'Nomor Telepon. Contoh: 0271823xxxx',
            'class' => 'number-input',
            'value' => old('supplier_telepon_number', $supplier->supplier_telepon_number ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'supplier_handphone_number',
            'label' => 'Nomor Handphone',
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_handphone_number',
            'name' => 'supplier_handphone_number',
            'placeholder' => 'Nomor Handphone. Contoh: 0812765xxxxx',
            'class' => 'number-input',
            'value' => old('supplier_handphone_number', $supplier->supplier_handphone_number ?? null),
        ]" />
    </div>
</div>

<div class="mb-4">
    <x-form.label :props="[
        'for' => 'supplier_npwp_number',
        'label' => 'Nomor NPWP',
    ]" />

    <x-form.input :props="[
        'id' => 'supplier_npwp_number',
        'name' => 'supplier_npwp_number',
        'placeholder' => 'Masukkan nomor NPWP 16 digit',
        'class' => 'number-input',
        'value' => old('supplier_npwp_number', $supplier->supplier_npwp_number ?? null),
    ]" />
</div>
{{-- 
<div class="mb-4">
    <x-form.label :props="[
        'for' => 'supplier_last_buy',
        'label' => 'Pembelian Terakhir',
    ]" />

    <x-form.input :props="[
        'id' => 'supplier_last_buy',
        'name' => 'supplier_last_buy',
        'placeholder' => 'Masukkan Pembelian Terakhir',
        'value' => old('supplier_last_buy', $supplier->supplier_last_buy ?? null),
    ]" />
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'supplier_first_debt',
            'label' => 'Hutang Awal',
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_first_debt',
            'name' => 'supplier_first_debt',
            'placeholder' => 'Masukkan Hutang Awal',
            'class' => 'price-input',
            'value' => old('supplier_first_debt', $supplier->supplier_first_debt ?? 0),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'supplier_purchase',
            'label' => 'Pembelian',
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_purchase',
            'name' => 'supplier_purchase',
            'placeholder' => 'Masukkan Pembelian',
            'class' => 'price-input',
            'value' => old('supplier_purchase', $customer->supplier_purchase ?? 0),
        ]" />
    </div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div class="mb-4">
        <x-form.label :props="[
            'for' => 'supplier_payment',
            'label' => 'Pembayaran',
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_payment',
            'name' => 'supplier_payment',
            'placeholder' => 'Masukkan Pembayaran',
            'class' => 'price-input',
            'value' => old('supplier_payment', $customer->supplier_payment ?? 0),
        ]" />
    </div>

    <div class="mb-4">
        <x-form.label :props="[
            'for' => 'supplier_last_debt',
            'label' => 'Hutang Akhir',
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_last_debt',
            'name' => 'supplier_last_debt',
            'placeholder' => 'Masukkan Hutang Akhir',
            'class' => 'price-input',
            'value' => old('supplier_last_debt', $customer->supplier_last_debt ?? 0),
        ]" />
    </div>
</div> --}}
