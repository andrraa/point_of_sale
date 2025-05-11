@extends('layouts.app')

@section('title', 'Supplier')

@section('navTitle', 'Daftar Pemasok')

@section('content')
    <div class="mb-6">
        <x-action-button :props="[
            'url' => route('supplier.create'),
            'label' => 'Pemasok Baru',
        ]" />
    </div>

    <div class="bg-white rounded-lg p-8 border border-gray-200">

    </div>
@endsection
