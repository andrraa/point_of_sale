@extends('layouts.app')

@section('title', 'Pemasok')

@section('navTitle', 'Ubah Pemasok')

@section('content')
    <div class="bg-white rounded-lg p-8 border border-gray-200">
        <form id="form-edit-customer" action="{{ route('supplier.update', $supplier->supplier_id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('supplier._form')

            <x-form.action :props="[
                'url' => route('supplier.index'),
            ]" />
        </form>
    </div>
@endsection
