@extends('layouts.app')

@section('title', 'Rak')

@section('navTitle', 'Rak')

@section('content')
    <div class="flex h-full max-h-full overflow-hidden gap-2">
        @include('partials.widget.sidebar')

        <main class="flex-1 h-full overflow-y-auto p-2">
            <div class="mb-4">
                <h1 class="font-medium tracking-wider text-blue-500">Ubah Rak</h1>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <form id="form-edit-category" action="{{ route('rack.update', $category->category_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('settings.rack._form')

                    <x-form.action :props="[
                        'url' => route('rack.index'),
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
