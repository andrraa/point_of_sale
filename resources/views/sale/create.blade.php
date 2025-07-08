@extends('layouts.app')

@section('title', 'Penjualan')

@section('navTitle', 'Penjualan Baru')

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <form id="form-create-customer" action="{{ route('sale.store') }}" method="POST">
            @csrf

            @include('sale._form')

            <x-form.action :props="[
                'url' => route('purchase.index'),
            ]" />
        </form>
    </div>
@endsection
