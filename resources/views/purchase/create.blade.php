@extends('layouts.app')

@section('title', 'Pembelian')

@section('navTitle', 'Pembelian Baru')

@section('content')
    <div class="bg-white rounded-lg p-8 border border-gray-200">
        <form id="form-create-customer" action="{{ route('purchase.store') }}" method="POST">
            @csrf

            @include('purchase._form')

            <x-form.action :props="[
                'url' => route('purchase.index'),
            ]" />
        </form>
    </div>
@endsection
