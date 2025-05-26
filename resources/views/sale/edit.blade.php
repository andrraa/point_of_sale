@extends('layouts.app')

@section('title', 'Penjualan')

@section('navTitle', 'Ubah Penjualan')

@section('content')
    <div class="bg-white rounded-lg p-8 border border-gray-200">
        <form id="form-edit-customer" action="{{ route('sale.update', $sale->sales_id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('sale._form')

            <x-form.action :props="[
                'url' => route('sale.index'),
            ]" />
        </form>
    </div>
@endsection
