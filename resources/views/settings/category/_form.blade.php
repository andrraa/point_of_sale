<div class="mb-2">
    <x-form.label :props="[
        'for' => 'category_code',
        'label' => 'Kode Kategori',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'category_code',
        'name' => 'category_code',
        'placeholder' => 'Kode Kategori. Contoh: 000',
        'value' => old('category_code', $category->category_code ?? null),
    ]" />
</div>

<div class="mb-6">
    <x-form.label :props="[
        'for' => 'category_name',
        'label' => 'Nama Kategori',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'category_name',
        'name' => 'category_name',
        'placeholder' => 'Nama Kategori. Contoh: BARANG IMPORT',
        'value' => old('category_name', $category->category_name ?? null),
    ]" />
</div>
