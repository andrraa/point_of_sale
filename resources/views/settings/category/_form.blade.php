<div class="mb-2">
    <x-form.label :props="[
        'for' => 'category_code',
        'label' => 'Category Code',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'category_code',
        'name' => 'category_code',
        'placeholder' => 'Category code. Example: 000',
        'value' => old('category_code', $category->category_code ?? null),
    ]" />
</div>

<div class="mb-6">
    <x-form.label :props="[
        'for' => 'category_name',
        'label' => 'Category Name',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'category_name',
        'name' => 'category_name',
        'placeholder' => 'Category name. Example: BARANG IMPORT',
        'value' => old('category_name', $category->category_name ?? null),
    ]" />
</div>
