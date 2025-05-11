@extends('layouts.app')

@section('title', 'Pelanggan')

@section('navTitle', 'Pelanggan Baru')

@section('content')
    <div class="bg-white rounded-lg p-8 border border-gray-200">
        <form id="form-create-customer" action="{{ route('customer.store') }}" method="POST">
            @csrf

            @include('customer._form')

            <x-form.action :props="[
                'url' => route('customer.index'),
            ]" />
        </form>
    </div>
@endsection
