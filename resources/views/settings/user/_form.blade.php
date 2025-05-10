<div class="mb-2">
    <x-form.label :props="[
        'for' => 'username',
        'label' => 'Nama Pengguna',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'username',
        'name' => 'username',
        'placeholder' => 'Nama pengguna. Contoh: admin',
        'value' => old('username', $user->username ?? null),
    ]" />
</div>

<div class="mb-2">
    <x-form.label :props="[
        'for' => 'password',
        'label' => 'Kata Sandi',
    ]" />

    <x-form.input :props="[
        'type' => 'password',
        'id' => 'password',
        'name' => 'password',
        'placeholder' => 'Kata sandi',
    ]" />
</div>

<div class="mb-6">
    @php
        $statuses = collect([
            0 => 'Tidak Aktif',
            1 => 'Aktif',
        ]);
    @endphp

    <x-form.label :props="[
        'for' => 'active',
        'label' => 'Status Pengguna',
        'required' => true,
    ]" />

    <x-form.select :props="[
        'id' => 'active',
        'name' => 'active',
        'value' => old('active', $user->active ?? null),
        'class' => 'w-full',
    ]" :options="$statuses" />
</div>
