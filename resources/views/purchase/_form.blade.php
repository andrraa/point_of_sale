<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'purchase_code',
            'label' => 'Bukti',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'purchase_code',
            'name' => 'purchase_code',
            'placeholder' => 'Kode Bukti. Contoh: 000',
            'value' => old('purchase_code', $purchase->purchase_code ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'purchase_invoice',
            'label' => 'Faktur Beli',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'purchase_invoice',
            'name' => 'purchase_invoice',
            'placeholder' => 'Faktu Beli',
            'value' => old('purchase_invoice', $purchase->purchase_invoice ?? null),
        ]" />
    </div>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'purchase_supplier',
            'label' => 'Pemasok / Supplier',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'purchase_supplier',
            'name' => 'purchase_supplier',
            'placeholder' => 'Pemasok / Supplier',
            'value' => old('purchase_supplier', $purchase->purchase_supplier ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'purchase_area',
            'label' => 'Wilayah',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'purchase_area',
            'name' => 'purchase_area',
            'placeholder' => 'Wilayah',
            'value' => old('purchase_area', $purchase->purchase_area ?? null),
        ]" />
    </div>
</div>

<div class="mb-4">
    <x-form.label :props="[
        'for' => 'purchase_note',
        'label' => 'Keterangan',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'purchase_note',
        'name' => 'purchase_note',
        'placeholder' => 'Keterangan',
        'value' => old('purchase_note', $purchase->purchase_note ?? null),
    ]" />
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-form.label :props="[
            'for' => 'purchase_payment_type',
            'label' => 'Cara Bayar',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'purchase_payment_type',
            'name' => 'purchase_payment_type',
            'placeholder' => 'Cara Bayar',
            'value' => old('purchase_payment_type', $purchase->purchase_payment_type ?? null),
        ]" />
    </div>

    <div>
        <x-form.label :props="[
            'for' => 'purchase_payment_due_date',
            'label' => 'Tanggal Jatuh Tempo',
            'required' => true,
        ]" />

        <x-form.input :props="[
            'id' => 'purchase_payment_due_date',
            'name' => 'purchase_payment_due_date',
            'placeholder' => 'Tanggal Jatuh Tempo',
            'value' => old('purchase_payment_due_date', $purchase->purchase_payment_due_date ?? null),
        ]" />
    </div>
</div>
