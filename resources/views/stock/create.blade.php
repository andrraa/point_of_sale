@extends('layouts.app')

@section('title', 'Stok')

@section('navTitle', 'Stok Baru')

@section('content')
    <div class="bg-white rounded-lg p-8 border border-gray-200">
        <form id="form-create-customer" action="{{ route('stock.store') }}" method="POST">
            @csrf

            @include('stock._form')

            <x-form.action :props="[
                'url' => route('stock.index'),
            ]" />
        </form>
    </div>
@endsection
