@extends('layouts.app')

@section('title', 'Kategori Pelanggan')

@section('navTitle', 'Kategori Pelanggan')

@section('content')
    <div class="flex h-full max-h-full overflow-hidden gap-2">
        @include('partials.widget.sidebar')

        <main class="flex-1 h-full overflow-y-auto px-4 py-2">
            <div class="pb-4">
                <h1 class="font-medium tracking-wider text-blue-500">Daftar Kategori Pelanggan</h1>
            </div>

            {{-- DATA --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <table class="w-full">
                    <thead class="text-left bg-gray-100">
                        <tr>
                            <th class="p-3 !text-[13px] tracking-wider text-blue-500">#</th>
                            <th class="p-3 !text-[13px] tracking-wider text-blue-500">Kode Kategori</th>
                            <th class="p-3 !text-[13px] tracking-wider text-blue-500">Nama Kategori</th>
                            <th class="p-3 !text-[13px] tracking-wider text-blue-500">Level Harga</th>
                            {{-- <th class="p-3 !text-[13px] tracking-wider text-blue-500">Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($customerCategories as $index => $category)
                            @php
                                $class = $index % 2 != 0 ? 'bg-gray-50' : '';
                                $border = $loop->last ? 'border-b border-b-gray-200' : '';
                            @endphp

                            <tr class="{{ $class }} {{ $border }}">
                                <td class="p-3 !text-[13px] tracking-wider">{{ $index + 1 }}</td>
                                <td class="p-3 !text-[13px] tracking-wider">{{ $category->category_code }}</td>
                                <td class="p-3 !text-[13px] tracking-wider">{{ $category->category_name }}</td>
                                <td class="p-3 !text-[13px] tracking-wider">{{ $category->category_price_level }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
@endsection

@push('scripts')
    {{-- <script type="module">
        $(document).ready(function() {
            $('.delete-button').on('click', function() {
                const categoryId = $(this).data('id');

                Swal.fire({
                    title: 'Apakah yakin?',
                    text: 'Kategori akan dihapus.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                }).then((res) => {
                    if (res.isConfirmed) {
                        $.ajax({
                            url: `/category/${categoryId}`,
                            type: 'DELETE',
                            success: function(response) {
                                location.reload();
                            }
                        });
                    }
                });
            });
        });
    </script> --}}
@endpush
