@extends('layouts.app')

@section('title', 'Stok Barang')

@section('navTitle', 'Daftar Stok')

@section('content')
    <div class="mb-6">
        <x-action-button :props="[
            'url' => route('stock.create'),
            'label' => 'Stok Baru',
        ]" />
    </div>

    <div class="bg-white rounded-lg p-8 border border-gray-200">

    </div>
@endsection
