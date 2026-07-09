@extends('layouts.app')

@section('title', 'Supplier Stock')

@section('navTitle', 'Supplier Baru')

@section('content')
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form id="form-create-supplier" action="{{ route('supplier-stock.store') }}" method="POST">
            @csrf

            @include('supplier-stock._form')

            <x-form.action :props="[
                'url' => route('supplier-stock.index'),
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

            $('.number-input').on('input',
                function() {
                    this.value = customFunction.numberOnly(this.value);
                });
        });
    </script>
@endpush
