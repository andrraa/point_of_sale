@extends('layouts.app')

@section('title', 'Pemasok')

@section('navTitle', 'Ubah Pemasok')

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <form id="form-edit-customer" action="{{ route('supplier.update', $supplier->supplier_id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('supplier._form')

            <x-form.action :props="[
                'url' => route('supplier.index'),
            ]" />
        </form>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/function.js')
    <script type="module" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script type="module">
        {!! $validator !!}

        $(document).ready(function() {
            const customFunction = window.CustomFunction;

            $('.price-input').on('input',
                function() {
                    this.value = customFunction.formatNumberToRupiah(customFunction.numberOnly(this.value));
                });

            $('.number-input').on('input',
                function() {
                    this.value = customFunction.numberOnly(this.value);
                });
        });
    </script>
@endpush
