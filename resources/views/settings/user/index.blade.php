@extends('layouts.app')

@section('title', 'User')

@section('navTitle', 'User')

@section('content')
    <div class="flex h-full max-h-full overflow-hidden">
        @include('partials.widget.sidebar')

        <main class="flex-1 h-full overflow-y-auto px-6">
        </main>
    </div>
@endsection

@push('scripts')
@endpush
