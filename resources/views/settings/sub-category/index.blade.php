@extends('layouts.app')

@section('title', 'Sub Category')

@section('navTitle', 'Sub Category')

@section('content')
    <div class="flex h-full max-h-full overflow-hidden gap-2">
        @include('partials.widget.sidebar')

        <main class="flex-1 h-full overflow-y-auto px-4 py-2">
            <div>
                <h1 class="font-medium tracking-wider text-blue-900">Sub Category List</h1>
            </div>

            <div class="py-4">
                <x-action-button :props="[
                    'url' => route('category.create'),
                    'label' => 'New Sub Category',
                ]" />
            </div>

            {{-- DATA --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <table class="w-full">
                    <thead class="text-left bg-gray-100">
                        <tr>
                            <th class="p-3 text-sm tracking-wider text-blue-900">#</th>
                            <th class="p-3 text-sm tracking-wider text-blue-900">Category Code</th>
                            <th class="p-3 text-sm tracking-wider text-blue-900">Category Name</th>
                            <th class="p-3 text-sm tracking-wider text-blue-900">Category Parent</th>
                            <th class="p-3 text-sm tracking-wider text-blue-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($subCategories as $index => $category)
                            @php
                                $class = $index % 2 != 0 ? 'bg-gray-50' : '';
                                $border = $loop->last ? 'border-b border-b-gray-200' : '';
                            @endphp

                            <tr class="{{ $class }} {{ $border }}">
                                <td class="p-3 text-sm tracking-wider">{{ $index + 1 }}</td>
                                <td class="p-3 text-sm tracking-wider">{{ $category->category_code }}</td>
                                <td class="p-3 text-sm tracking-wider uppercase">{{ $category->category_name }}</td>
                                <td class="p-3 text-sm tracking-wider">
                                    <div class="flex gap-1.5">
                                        <a href="{{ route('category.edit', ['category' => $category->category_id]) }}"
                                            class="px-3 py-1.5 rounded-lg border text-xs border-blue-900 text-blue-900 hover:bg-blue-900 hover:text-white font-medium tracking-wide transition duration-200">
                                            Edit
                                        </a>
                                        <button type="button" data-id="{{ $category->category_id }}"
                                            class="delete-button px-3 py-1.5 rounded-lg border text-xs border-red-900 text-red-900 hover:bg-red-900 hover:text-white font-medium tracking-wide transition duration-200 cursor-pointer">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
@endsection

@push('scripts')
@endpush
