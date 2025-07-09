@extends('layouts.app')

@section('title', 'Toko')

@section('navTitle', 'Toko')

@section('content')
    <div class="flex h-full max-h-full overflow-hidden gap-2">
        @include('partials.widget.sidebar')

        <main class="flex-1 h-full overflow-y-auto px-4 py-2">
            <div class="mb-4">
                <h1 class="font-medium tracking-wider text-blue-500">Informasi Toko</h1>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-lg">
                <form action="{{ route('store.store') }}" method="POST">
                    @csrf

                    <div class="mb-2">
                        <x-form.label :props="[
                            'for' => 'store_name',
                            'label' => 'Nama Toko',
                            'required' => true,
                        ]" />

                        <x-form.input :props="[
                            'id' => 'store_name',
                            'name' => 'store_name',
                            'value' => $store->store_name ?? null,
                            'placeholder' => 'Masukkan nama toko',
                        ]" />
                    </div>

                    <div class="mb-2">
                        <x-form.label :props="[
                            'for' => 'store_address',
                            'label' => 'Alamat Toko',
                            'required' => true,
                        ]" />

                        <x-form.input :props="[
                            'id' => 'store_address',
                            'name' => 'store_address',
                            'value' => $store->store_address ?? null,
                            'placeholder' => 'Masukkan alamat toko',
                        ]" />
                    </div>

                    <div class="mb-4">
                        <x-form.label :props="[
                            'for' => 'store_phone_number',
                            'label' => 'Nomor Telepon Toko',
                            'required' => true,
                        ]" />

                        <x-form.input :props="[
                            'id' => 'store_phone_number',
                            'name' => 'store_phone_number',
                            'value' => $store->store_phone_number ?? null,
                            'placeholder' => 'Masukkan nomor telepon toko',
                            'class' => 'number-input',
                        ]" />
                    </div>

                    <div class="flex justify-end">
                        <div class="w-1/7">
                            <x-form.submit :props="[
                                'label' => 'Simpan',
                            ]" />
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/function.js')

    <script type="module">
        $(document).ready(function() {
            const customFunction = window.CustomFunction;

            $('.number-input').on('input',
                function() {
                    this.value = customFunction.numberOnly(this.value);
                });
        });
    </script>
@endpush
