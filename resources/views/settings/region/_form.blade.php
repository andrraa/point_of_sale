<div class="mb-2">
    <x-form.label :props="[
        'for' => 'region_code',
        'label' => 'Kode Wilayah',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'region_code',
        'name' => 'region_code',
        'placeholder' => 'Kode Wilayah. Contoh: 000',
        'value' => old('region_code', $region->region_code ?? null),
    ]" />
</div>

<div class="mb-6">
    <x-form.label :props="[
        'for' => 'region_name',
        'label' => 'Nama Wilayah',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'region_name',
        'name' => 'region_name',
        'placeholder' => 'Nama Wilayah. Contoh: LOKAL',
        'value' => old('region_name', $region->region_name ?? null),
    ]" />
</div>
