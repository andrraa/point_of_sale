@extends('layouts.app')

@section('title', 'Pelanggan')

@section('navTitle', 'Ubah Pelanggan')

@section('content')
    <div class="bg-white rounded-lg p-8 border border-gray-200">
        <form id="form-edit-customer" action="{{ route('customer.update', $customer->customer_id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('customer._form')

            <x-form.action :props="[
                'url' => route('customer.index'),
            ]" />
        </form>
    </div>
@endsection
