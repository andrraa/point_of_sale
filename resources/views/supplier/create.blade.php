@extends('layouts.app')

@section('title', 'Pemasok')

@section('navTitle', 'Pemasok Baru')

@section('content')
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="mb-5 pb-4 border-b border-slate-100">
            <h2 class="text-base font-semibold text-slate-800">Tambah Pemasok</h2>
            <p class="text-sm text-slate-500 mt-0.5">Lengkapi data pemasok baru</p>
        </div>

        <form id="form-create-supplier" action="{{ route('supplier.store') }}" method="POST">
            @csrf

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
