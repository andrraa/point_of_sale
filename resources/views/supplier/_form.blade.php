<div class="grid grid-cols-2 gap-5 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'supplier_code',
            'label' => 'Kode Pemasok',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
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
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.input :props="[
            'id' => 'supplier_name',
            'name' => 'supplier_name',
            'placeholder' => 'Nama Pemasok. Contoh: Rudi',
            'value' => old('supplier_name', $supplier->supplier_name ?? null),
        ]" />
    </div>
</div>

<div class="grid grid-cols-2 gap-5 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'supplier_address',
            'label' => 'Alamat Pemasok',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
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
            'class' => 'text-slate-700 font-medium text-sm',
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
        'class' => 'text-slate-700 font-medium text-sm',
    ]" />

    <x-form.input :props="[
        'id' => 'supplier_contact_person',
        'name' => 'supplier_contact_person',
        'placeholder' => 'Masukkan orang yang dapat dihubungi',
        'value' => old('supplier_contact_person', $supplier->supplier_contact_person ?? null),
    ]" />
</div>

<div class="grid grid-cols-2 gap-5 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'supplier_telepon_number',
            'label' => 'Nomor Telepon',
            'class' => 'text-slate-700 font-medium text-sm',
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
            'class' => 'text-slate-700 font-medium text-sm',
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
        'class' => 'text-slate-700 font-medium text-sm',
    ]" />

    <x-form.input :props="[
        'id' => 'supplier_npwp_number',
        'name' => 'supplier_npwp_number',
        'placeholder' => 'Masukkan nomor NPWP 16 digit',
        'class' => 'number-input',
        'value' => old('supplier_npwp_number', $supplier->supplier_npwp_number ?? null),
    ]" />
</div>
