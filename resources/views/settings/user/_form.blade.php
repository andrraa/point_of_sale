<div class="mb-2">
    <x-form.label :props="[
        'for' => 'full_name',
        'label' => 'Nama Lengkap',
        'required' => true,
    ]" />

    <x-form.input :props="[
        'id' => 'full_name',
        'name' => 'full_name',
        'placeholder' => 'Nama lengkap',
        'value' => old('full_name', $user->full_name ?? null),
    ]" />
</div>

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
    <x-form.label :props="[
        'for' => 'user_role_id',
        'label' => 'Akses',
        'required' => true,
    ]" />

    <x-form.select :props="[
        'id' => 'user_role_id',
        'name' => 'user_role_id',
        'value' => old('user_role_id', $user->user_role_id ?? null),
        'class' => 'w-full',
    ]" :options="$roles" />
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
