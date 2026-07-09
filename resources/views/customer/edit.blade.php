@extends('layouts.app')

@section('title', 'Pelanggan')

@section('navTitle', 'Ubah Pelanggan')

@section('content')
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="mb-5 pb-4 border-b border-slate-100">
            <h2 class="text-base font-semibold text-slate-800">Ubah Pelanggan</h2>
            <p class="text-sm text-slate-500 mt-0.5">Perbarui data pelanggan</p>
        </div>

        <form id="form-edit-customer" action="{{ route('customer.update', $customer->customer_id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('customer._form')

            <x-form.action :props="[
                'url' => route('customer.index'),
            ]" />
        </form>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/function.js')
    <script type="module" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script type="module">
        {!! $validator !!}
    </script>
    <script type="module">
        $(document).ready(function() {
            const customFunction = window.CustomFunction;

            $('.price-input').on('input',
                function() {
                    this.value = customFunction.formatNumberToRupiah(this.value.replace(/[^0-9]/g, ''));
                });

            $('.number-input').on('input',
                function() {
                    this.value = customFunction.numberOnly(this.value);
                });
        });
    </script>
@endpush
