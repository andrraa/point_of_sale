@extends('layouts.app')

@section('title', 'Kategori Pelanggan')

@section('navTitle', 'Kategori Pelanggan')

@section('content')
    <div class="flex h-full max-h-full overflow-hidden gap-4">
        @include('partials.widget.sidebar')

        <main class="flex-1 h-full overflow-y-auto">
            <div class="mb-5">
                <h1 class="text-base font-semibold text-slate-800">Ubah Kategori Pelanggan</h1>
                <p class="text-sm text-slate-500 mt-0.5">Perbarui kategori pelanggan</p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <form id="form-edit-category" action="{{ route('customer-category.update', $category->category_id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    @include('settings.customer._form')

                    <x-form.action :props="[
                        'url' => route('customer-category.index'),
                    ]" />
                </form>
            </div>
        </main>
    </div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script type="module">
        {!! $validator !!}
    </script>
@endpush
