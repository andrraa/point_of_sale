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
            'for' => 'suppler_area',
            'label' => 'Wilayah Pemasok',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'suppler_area',
            'name' => 'suppler_area',
            'placeholder' => 'Wilayah Pemasok. Contoh: Jakarta',
            'value' => old('suppler_area', $supplier->suppler_area ?? null),
        ]" />
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
            'for' => 'supplier_phone',
            'label' => 'Nomor Telepon',
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_phone',
            'name' => 'supplier_phone',
            'placeholder' => 'Nomor Telepon. Contoh: 0271823xxxx',
            'value' => old('supplier_phone', $supplier->supplier_phone ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'supplier_phone_number',
            'label' => 'Nomor Handphone',
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_phone_number',
            'name' => 'supplier_phone_number',
            'placeholder' => 'Nomor Handphone. Contoh: 0812765xxxxx',
            'value' => old('supplier_phone_number', $supplier->supplier_phone_number ?? null),
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
        'value' => old('supplier_npwp_number', $supplier->supplier_npwp_number ?? null),
    ]" />
</div>

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
            'for' => 'supplier_credit_start',
            'label' => 'Hutang Awal',
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_credit_start',
            'name' => 'supplier_credit_start',
            'placeholder' => 'Masukkan Hutang Awal',
            'value' => old('supplier_credit_start', $supplier->supplier_credit_start ?? 0),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'supplier_buy',
            'label' => 'Pembelian',
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_buy',
            'name' => 'supplier_buy',
            'placeholder' => 'Masukkan Pembelian',
            'value' => old('supplier_buy', $customer->supplier_buy ?? 0),
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
            'value' => old('supplier_payment', $customer->supplier_payment ?? 0),
        ]" />
    </div>

    <div class="mb-4">
        <x-form.label :props="[
            'for' => 'supplier_credit_end',
            'label' => 'Hutang Akhir',
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_credit_end',
            'name' => 'supplier_credit_end',
            'placeholder' => 'Masukkan Hutang Akhir',
            'value' => old('supplier_credit_end', $customer->supplier_credit_end ?? 0),
        ]" />
    </div>
</div>
