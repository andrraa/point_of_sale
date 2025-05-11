@extends('layouts.app')

@section('title', 'Pemasok')

@section('navTitle', 'Pemasok Baru')

@section('content')
    <div class="bg-white rounded-lg p-8 border border-gray-200">
        <form id="form-create-customer" action="{{ route('supplier.store') }}" method="POST">
            @csrf

            @include('supplier._form')

            <x-form.action :props="[
                'url' => route('supplier.index'),
            ]" />
        </form>
    </div>
@endsection
