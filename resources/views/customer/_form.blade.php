<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'customer_code',
            'label' => 'Kode Pelanggan',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'customer_code',
            'name' => 'customer_code',
            'placeholder' => 'Kode Pelanggan. Contoh: 000',
            'value' => old('customer_code', $customer->customer_code ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'customer_name',
            'label' => 'Nama Pelanggan',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'customer_name',
            'name' => 'customer_name',
            'placeholder' => 'Nama Pelanggan. Contoh: Rudi',
            'value' => old('customer_name', $customer->customer_name ?? null),
        ]" />
    </div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'customer_address',
            'label' => 'Alamat Pelanggan',
            'required' => true,
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
            'for' => 'customer_area',
            'label' => 'Wilayah Pelanggan',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'customer_area',
            'name' => 'customer_area',
            'placeholder' => 'Wilayah Pelanggan. Contoh: Jakarta',
            'value' => old('customer_area', $customer->customer_area ?? null),
        ]" />
    </div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        @php
            $statuses = collect([
                'Harga Jual 1' => 'Harga Jual 1',
                'Harga Jual 2' => 'Harga Jual 2',
                'Harga Jual 3' => 'Harga Jual 3',
                'Harga Jual 4' => 'Harga Jual 4',
            ]);
        @endphp

        <x-form.label :props="[
            'for' => 'customer_price_sale',
            'label' => 'Harga Jual',
            'required' => true,
        ]" />

        <x-form.select :props="[
            'id' => 'customer_price_sale',
            'name' => 'customer_price_sale',
            'value' => old('customer_price_sale', $customer->customer_price_sale ?? null),
            'class' => 'w-full',
        ]" :options="$statuses" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'customer_discount',
            'label' => 'Diskon Harga Jual (%)',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'customer_discount',
            'name' => 'customer_discount',
            'placeholder' => 'Diskon Harga Jual. Contoh: 10',
            'value' => old('customer_discount', $customer->customer_discount ?? null),
        ]" />
    </div>
</div>

<div class="mb-4">
    <x-form.label :props="[
        'for' => 'customer_contact_person',
        'label' => 'Orang Yang Dapat Dihubungi',
    ]" />

    <x-form.input :props="[
        'id' => 'customer_contact_person',
        'name' => 'customer_contact_person',
        'placeholder' => 'Masukkan orang yang dapat dihubungi',
        'value' => old('customer_contact_person', $customer->customer_contact_person ?? null),
    ]" />
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'customer_phone',
            'label' => 'Nomor Telepon',
        ]" />

        <x-form.input :props="[
            'id' => 'customer_phone',
            'name' => 'customer_phone',
            'placeholder' => 'Nomor Telepon. Contoh: 0271823xxxx',
            'value' => old('customer_phone', $customer->customer_phone ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'customer_phone_number',
            'label' => 'Nomor Handphone',
        ]" />

        <x-form.input :props="[
            'id' => 'customer_phone_number',
            'name' => 'customer_phone_number',
            'placeholder' => 'Nomor Handphone. Contoh: 0812765xxxxx',
            'value' => old('customer_phone_number', $customer->customer_phone_number ?? null),
        ]" />
    </div>
</div>

<div class="mb-4">
    <x-form.label :props="[
        'for' => 'customer_npwp_number',
        'label' => 'Nomor NPWP',
    ]" />

    <x-form.input :props="[
        'id' => 'customer_npwp_number',
        'name' => 'customer_npwp_number',
        'placeholder' => 'Masukkan nomor NPWP 16 digit',
        'value' => old('customer_npwp_number', $customer->customer_npwp_number ?? null),
    ]" />
</div>

<div class="mb-4">
    <x-form.label :props="[
        'for' => 'customer_last_sale',
        'label' => 'Penjualan Akhir',
    ]" />

    <x-form.input :props="[
        'id' => 'customer_last_sale',
        'name' => 'customer_last_sale',
        'placeholder' => 'Masukkan penjualan akhir',
        'value' => old('customer_last_sale', $customer->customer_last_sale ?? null),
    ]" />
</div>

<div class="mb-4">
    <x-form.label :props="[
        'for' => 'customer_credit_limit',
        'label' => 'Plafon Piutang',
    ]" />

    <x-form.input :props="[
        'id' => 'customer_credit_limit',
        'name' => 'customer_credit_limit',
        'placeholder' => 'Masukkan Plafon Piutang',
        'value' => old('customer_credit_limit', $customer->customer_credit_limit ?? null),
    ]" />
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'customer_credit_start',
            'label' => 'Piutang Awal',
        ]" />

        <x-form.input :props="[
            'id' => 'customer_credit_start',
            'name' => 'customer_credit_start',
            'placeholder' => 'Masukkan Piutang Awal',
            'value' => old('customer_credit_start', $customer->customer_credit_start ?? 0),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'customer_sales',
            'label' => 'Penjualan',
        ]" />

        <x-form.input :props="[
            'id' => 'customer_sales',
            'name' => 'customer_sales',
            'placeholder' => 'Masukkan Penjualan',
            'value' => old('customer_sales', $customer->customer_sales ?? 0),
        ]" />
    </div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div class="mb-4">
        <x-form.label :props="[
            'for' => 'customer_payment',
            'label' => 'Pelunasan',
        ]" />

        <x-form.input :props="[
            'id' => 'customer_payment',
            'name' => 'customer_payment',
            'placeholder' => 'Masukkan Pelunasan',
            'value' => old('customer_payment', $customer->customer_payment ?? 0),
        ]" />
    </div>

    <div class="mb-4">
        <x-form.label :props="[
            'for' => 'customer_credit_end',
            'label' => 'Piutang Akhir',
        ]" />

        <x-form.input :props="[
            'id' => 'customer_credit_end',
            'name' => 'customer_credit_end',
            'placeholder' => 'Masukkan Piutang Akhir',
            'value' => old('customer_credit_end', $customer->customer_credit_end ?? 0),
        ]" />
    </div>
</div>
