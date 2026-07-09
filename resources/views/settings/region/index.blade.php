@extends('layouts.app')

@section('title', 'Wilayah')

@section('navTitle', 'Wilayah')

@section('content')
    <div class="flex h-full max-h-full overflow-hidden gap-4">
        @include('partials.widget.sidebar')

        <main class="flex-1 h-full overflow-y-auto">
            <div class="mb-5">
                <h1 class="text-base font-semibold text-slate-800">Daftar Wilayah</h1>
                <p class="text-sm text-slate-500 mt-0.5">Kelola data wilayah</p>
            </div>

            <div class="mb-5">
                <x-action-button :props="[
                    'url' => route('region.create'),
                    'label' => 'Wilayah Baru',
                ]" />
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="p-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                                <th class="p-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode Wilayah</th>
                                <th class="p-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Wilayah</th>
                                <th class="p-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($regions as $index => $region)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-3 text-slate-500">{{ $index + 1 }}</td>
                                    <td class="p-3 text-slate-700">{{ $region->region_code }}</td>
                                    <td class="p-3 text-slate-700">{{ $region->region_name }}</td>
                                    <td class="p-3">
                                        <div class="flex gap-1.5">
                                            <a href="{{ route('region.edit', $region->region_id) }}"
                                                class="px-3 py-1.5 rounded-lg border text-xs border-slate-700 text-slate-700 hover:bg-slate-700 hover:text-white font-medium tracking-wide transition-all duration-200">
                                                Ubah
                                            </a>
                                            <button type="button" data-id="{{ $region->region_id }}"
                                                class="delete-button px-3 py-1.5 rounded-lg border text-xs border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-medium tracking-wide transition-all duration-200 cursor-pointer">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
