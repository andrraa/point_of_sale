@extends('layouts.app')

@section('title', 'Pengguna')

@section('navTitle', 'Pengguna')

@section('content')
    <div class="flex h-full max-h-full overflow-hidden gap-4">
        @include('partials.widget.sidebar')

        <main class="flex-1 h-full overflow-y-auto">
            <div class="mb-5">
                <h1 class="text-base font-semibold text-slate-800">Pengguna Baru</h1>
                <p class="text-sm text-slate-500 mt-0.5">Tambah pengguna baru</p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <form id="form-create-user" action="{{ route('user.store') }}" method="POST">
                    @csrf

                    @include('settings.user._form')

                    <x-form.action :props="[
                        'url' => route('user.index'),
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
