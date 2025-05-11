@extends('layouts.app')

@section('title', 'Pelanggan')

@section('navTitle', 'Daftar Pelanggan')

@section('content')
    <div class="mb-6">
        <x-action-button :props="[
            'url' => route('customer.create'),
            'label' => 'Pelanggan Baru',
        ]" />
    </div>

    <div class="bg-white rounded-lg p-8 border border-gray-200">

    </div>
@endsection
