@extends('layouts.app')

@section('title', 'Stok')

@section('navTitle', 'Ubah Stok')

@section('content')
    <div class="bg-white rounded-lg p-8 border border-gray-200">
        <form id="form-edit-customer" action="{{ route('stock.update', $stock->stock_id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('stock._form')

            <x-form.action :props="[
                'url' => route('stock.index'),
            ]" />
        </form>
    </div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script type="module">
        {!! $validator !!}
    </script>
@endpush
