<div class="grid grid-cols-2 gap-5 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'customer_category_id',
            'label' => 'Kategori Pelanggan',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.select :props="[
            'id' => 'customer_category_id',
            'name' => 'customer_category_id',
            'value' => old('customer_category_id', $customer->customer_category_id ?? null),
            'class' => 'w-full',
        ]" :options="$categories" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'customer_name',
            'label' => 'Nama Pelanggan',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.input :props="[
            'id' => 'customer_name',
            'name' => 'customer_name',
            'placeholder' => 'Nama Pelanggan. Contoh: Rudi',
            'value' => old('customer_name', $customer->customer_name ?? null),
        ]" />
    </div>
</div>

<div class="grid grid-cols-2 gap-5 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'customer_address',
            'label' => 'Alamat Pelanggan',
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.input :props="[
            'id' => 'customer_address',
            'name' => 'customer_address',
            'placeholder' => 'Alamat Pelanggan. Contoh: Jakarta',
            'value' => old('customer_address', $customer->customer_address ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'customer_region_id',
            'label' => 'Wilayah Pelanggan',
            'required' => true,
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.select :props="[
            'id' => 'customer_region_id',
            'name' => 'customer_region_id',
            'value' => old('customer_region_id', $customer->customer_region_id ?? null),
            'class' => 'w-full',
        ]" :options="$regions" />
    </div>
</div>

<div class="grid grid-cols-2 gap-5 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'customer_phone_number',
            'label' => 'Nomor Handphone',
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.input :props="[
            'id' => 'customer_phone_number',
            'name' => 'customer_phone_number',
            'placeholder' => 'Nomor Handphone. Contoh: 0812765xxxxx',
            'value' => old('customer_phone_number', $customer->customer_phone_number ?? null),
            'class' => 'number-input',
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'customer_npwp_number',
            'label' => 'Nomor NPWP',
            'class' => 'text-slate-700 font-medium text-sm',
        ]" />

        <x-form.input :props="[
            'id' => 'customer_npwp_number',
            'name' => 'customer_npwp_number',
            'placeholder' => 'Masukkan nomor NPWP 16 digit',
            'value' => old('customer_npwp_number', $customer->customer_npwp_number ?? null),
            'class' => 'number-input',
        ]" />
    </div>
</div>
