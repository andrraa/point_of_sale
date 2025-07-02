@extends('layouts.app')

@section('title', 'Category')

@section('navTitle', 'Category')

@section('content')
    <div class="flex h-full max-h-full overflow-hidden gap-2">
        @include('partials.widget.sidebar')

        <main class="flex-1 h-full overflow-y-auto p-2">
            <div class="mb-4">
                <h1 class="font-medium tracking-wider text-blue-500">Ubah Kategori</h1>
            </div>

            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <form id="form-edit-category" action="{{ route('category.update', $category->category_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('settings.category._form')

                    <x-form.action :props="[
                        'url' => route('category.index'),
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
