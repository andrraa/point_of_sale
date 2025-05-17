<div class="mb-2">
    <x-form.label :props="[
        'for' => 'category_type',
        'label' => 'Tipe Kategori',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'category_type',
        'name' => 'category_type',
        'placeholder' => 'Tipe Kategori',
        'value' => 'Pelanggan',
        'readonly' => true,
    ]" />
</div>

<div class="mb-2">
    <x-form.label :props="[
        'for' => 'category_code',
        'label' => 'Kode Kategori',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'category_code',
        'name' => 'category_code',
        'placeholder' => 'Kode kategori. Contoh: 000',
        'value' => old('category_code', $category->category_code ?? null),
    ]" />
</div>

<div class="mb-2">
    <x-form.label :props="[
        'for' => 'category_name',
        'label' => 'Nama Kategori',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'category_name',
        'name' => 'category_name',
        'placeholder' => 'Nama Kategori. Contoh: GROSIR',
        'value' => old('category_name', $category->category_name ?? null),
    ]" />
</div>
