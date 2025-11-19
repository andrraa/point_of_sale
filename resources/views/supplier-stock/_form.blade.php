<div class="mb-3">
    <x-form.label :props="[
        'for' => 'ss_name',
        'label' => 'Nama Supplier',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'ss_name',
        'name' => 'ss_name',
        'placeholder' => 'Nama Supplier',
        'value' => old('ss_name', $supplierStock->ss_name ?? null),
    ]" />
</div>

<div class="mb-3">
    <x-form.label :props="[
        'for' => 'ss_phone',
        'label' => 'No. Handphone Supplier',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'ss_phone',
        'name' => 'ss_phone',
        'placeholder' => 'No. Handphone Supplier',
        'class' => 'number-input',
        'value' => old('ss_phone', $supplierStock->ss_phone ?? null),
    ]" />
</div>

<div class="mb-3">
    <x-form.label :props="[
        'for' => 'ss_address',
        'label' => 'Alamat Supplier',
    ]" />

    <x-form.input :props="[
        'id' => 'ss_address',
        'name' => 'ss_address',
        'placeholder' => 'Alamat Supplier',
        'value' => old('ss_address', $supplierStock->ss_address ?? null),
    ]" />
</div>

<div class="mb-6">
    <x-form.label :props="[
        'for' => 'ss_description',
        'label' => 'Keterangan Supplier',
    ]" />

    <x-form.textarea :props="[
        'id' => 'ss_description',
        'name' => 'ss_description',
        'placeholder' => 'Keterangan Supplier',
        'value' => old('ss_description', $supplierStock->ss_description ?? null),
    ]" />
</div>