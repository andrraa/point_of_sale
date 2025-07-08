@extends('layouts.app')

@section('title', 'Wilayah')

@section('navTitle', 'Wilayah')

@section('content')
    <div class="flex h-full max-h-full overflow-hidden gap-2">
        @include('partials.widget.sidebar')

        <main class="flex-1 h-full overflow-y-auto px-4 py-2">
            <div>
                <h1 class="font-medium tracking-wider text-blue-500">Daftar Wilayah</h1>
            </div>

            <div class="py-4">
                <x-action-button :props="[
                    'url' => route('region.create'),
                    'label' => 'Wilayah Baru',
                ]" />
            </div>

            {{-- DATA --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <table class="w-full">
                    <thead class="text-left bg-gray-100">
                        <tr>
                            <th class="p-3 !text-[13px] tracking-wider text-blue-500">#</th>
                            <th class="p-3 !text-[13px] tracking-wider text-blue-500">Kode Wilayah</th>
                            <th class="p-3 !text-[13px] tracking-wider text-blue-500">Nama Wilayah</th>
                            <th class="p-3 !text-[13px] tracking-wider text-blue-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($regions as $index => $region)
                            @php
                                $class = $index % 2 != 0 ? 'bg-gray-50' : '';
                                $border = $loop->last ? 'border-b border-b-gray-200' : '';
                            @endphp

                            <tr class="{{ $class }} {{ $border }}">
                                <td class="p-3 !text-[13px] tracking-wider">{{ $index + 1 }}</td>
                                <td class="p-3 !text-[13px] tracking-wider">{{ $region->region_code }}</td>
                                <td class="p-3 !text-[13px] tracking-wider">{{ $region->region_name }}</td>
                                <td class="p-3 !text-[13px] tracking-wider">
                                    <div class="flex gap-1.5">
                                        <a href="{{ route('region.edit', $region->region_id) }}"
                                            class="px-3 py-1.5 rounded-lg border text-xs border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white font-medium tracking-wide transition duration-200">
                                            Ubah
                                        </a>
                                        <button type="button" data-id="{{ $region->region_id }}"
                                            class="delete-button px-3 py-1.5 rounded-lg border text-xs border-red-900 text-red-900 hover:bg-red-900 hover:text-white font-medium tracking-wide transition duration-200 cursor-pointer">
                                            Hapus
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
    <script type="module">
        $(document).ready(function() {
            $('.delete-button').on('click', function() {
                const regionId = $(this).data('id');

                Swal.fire({
                    title: 'Apakah yakin?',
                    text: 'Wilayah akan dihapus.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                }).then((res) => {
                    if (res.isConfirmed) {
                        $.ajax({
                            url: `/region/${regionId}`,
                            type: 'DELETE',
                            success: function(response) {
                                location.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
