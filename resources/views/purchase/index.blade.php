@extends('layouts.app')

@section('title', 'Pembelian')

@section('navTitle', 'Daftar Pembelian')

@section('content')
    <div class="mb-6">
        <x-action-button :props="[
            'url' => route('purchase.create'),
            'label' => 'Pembelian Baru',
        ]" />
    </div>

    <div class="bg-white rounded-lg p-8 border border-gray-200">

    </div>
@endsection
