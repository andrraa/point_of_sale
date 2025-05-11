@extends('layouts.app')

@section('title', 'Penjualan')

@section('navTitle', 'Daftar Penjualan')

@section('content')
    <div class="mb-6">
        <x-action-button :props="[
            'url' => route('sale.create'),
            'label' => 'Penjualan Baru',
        ]" />
    </div>

    <div class="bg-white rounded-lg p-8 border border-gray-200">

    </div>
@endsection
