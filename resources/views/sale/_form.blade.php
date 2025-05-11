<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'sale_code',
            'label' => 'Bukti',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'sale_code',
            'name' => 'sale_code',
            'placeholder' => 'Kode Bukti. Contoh: 000',
            'value' => old('sale_code', $sale->sale_code ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'sale_date',
            'label' => 'Tanggal',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'sale_date',
            'name' => 'sale_date',
            'placeholder' => 'Tanggal',
            'value' => old('sale_date', $sale->sale_date ?? null),
        ]" />
    </div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'sale_customer',
            'label' => 'Pelanggan',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'sale_customer',
            'name' => 'sale_customer',
            'placeholder' => 'Pelanggan',
            'value' => old('sale_customer', $sale->sale_customer ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'sale_area',
            'label' => 'Wilayah',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'sale_area',
            'name' => 'sale_area',
            'placeholder' => 'Wilayah',
            'value' => old('sale_area', $sale->sale_area ?? null),
        ]" />
    </div>
</div>

<div class="mb-4">
    <x-form.label :props="[
        'for' => 'sale_sales',
        'label' => 'Salesman',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'sale_sales',
        'name' => 'sale_sales',
        'placeholder' => 'Salesman',
        'value' => old('sale_sales', $sale->sale_sales ?? null),
    ]" />
</div>

<div class="mb-4">
    <x-form.label :props="[
        'for' => 'sale_note',
        'label' => 'Keterangan',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'sale_note',
        'name' => 'sale_note',
        'placeholder' => 'Keterangan',
        'value' => old('sale_note', $sale->sale_note ?? null),
    ]" />
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'sale_payment_type',
            'label' => 'Cara Bayar',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'sale_payment_type',
            'name' => 'sale_payment_type',
            'placeholder' => 'Cara Bayar',
            'value' => old('sale_payment_type', $sale->sale_payment_type ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'sale_payment_due_date',
            'label' => 'Tanggal Jatuh Tempo',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'sale_payment_due_date',
            'name' => 'sale_payment_due_date',
            'placeholder' => 'Tanggal Jatuh Tempo',
            'value' => old('sale_payment_due_date', $sale->sale_payment_due_date ?? null),
        ]" />
    </div>
</div>
