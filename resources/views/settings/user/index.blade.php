@extends('layouts.app')

@section('title', 'Pengguna')

@section('navTitle', 'Pengguna')

@section('content')
    <div class="flex h-full max-h-full overflow-hidden gap-2">
        @include('partials.widget.sidebar')

        <main class="flex-1 h-full overflow-y-auto px-4 py-2">
            <div>
                <h1 class="font-medium tracking-wider text-blue-900">Daftar Pengguna</h1>
            </div>

            <div class="py-4">
                <x-action-button :props="[
                    'url' => route('user.create'),
                    'label' => 'Pengguna Baru',
                ]" />
            </div>

            {{-- DATA --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <table class="w-full">
                    <thead class="text-left bg-gray-100">
                        <tr>
                            <th class="p-3 text-sm tracking-wider text-blue-900">#</th>
                            <th class="p-3 text-sm tracking-wider text-blue-900">Nama Pengguna</th>
                            <th class="p-3 text-sm tracking-wider text-blue-900">Status</th>
                            <th class="p-3 text-sm tracking-wider text-blue-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($users as $index => $user)
                            @php
                                $class = $index % 2 != 0 ? 'bg-gray-50' : '';
                                $border = $loop->last ? 'border-b border-b-gray-200' : '';
                            @endphp

                            <tr class="{{ $class }} {{ $border }}">
                                <td class="p-3 text-sm tracking-wider">{{ $index + 1 }}</td>
                                <td class="p-3 text-sm tracking-wider   ">{{ $user->username }}</td>
                                <td class="p-3 text-sm tracking-wider">
                                    @php
                                        $statusTitle = $user->active == 1 ? 'Aktif' : 'Tidak Aktif';
                                        $statusClass = $user->active == 1 ? 'bg-blue-900' : 'bg-red-900';
                                    @endphp

                                    <span
                                        class="rounded-lg px-2 py-1 text-xs border tracking-widest font-medium text-white {{ $statusClass }}">
                                        {{ $statusTitle }}
                                    </span>
                                </td>
                                <td class="p-3 text-sm tracking-wider">
                                    <div class="flex gap-1.5">
                                        <a href="{{ route('user.edit', $user->user_id) }}"
                                            class="px-3 py-1.5 rounded-lg border text-xs border-blue-900 text-blue-900 hover:bg-blue-900 hover:text-white font-medium tracking-wide transition duration-200">
                                            Ubah
                                        </a>
                                        <button type="button" data-id="{{ $user->user_id }}"
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
                const userId = $(this).data('id');

                Swal.fire({
                    title: 'Apakah yakin?',
                    text: 'Pengguna akan dihapus.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                }).then((res) => {
                    if (res.isConfirmed) {
                        $.ajax({
                            url: `/user/${userId}`,
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
