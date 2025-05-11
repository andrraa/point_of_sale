@extends('layouts.app')

@section('title', 'Pembelian')

@section('navTitle', 'Ubah Pembelian')

@section('content')
    <div class="bg-white rounded-lg p-8 border border-gray-200">
        <form id="form-edit-customer" action="{{ route('purchase.update', $purchase->purchase_id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('purchase._form')

            <x-form.action :props="[
                'url' => route('purchase.index'),
            ]" />
        </form>
    </div>
@endsection
