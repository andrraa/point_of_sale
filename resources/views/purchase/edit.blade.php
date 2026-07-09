@extends('layouts.app')

@section('title', 'Pembelian')

@section('navTitle', 'Ubah Pembelian')

@section('content')
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form id="form-edit-purchase"
            action="{{ route('purchase.update', $purchase->purchase_id) }}"
            method="POST">
            @csrf
            @method('PUT')

            @include('purchase._form')

            <div class="pb-10 pt-4">
                <table class="w-full">
                    <thead class="text-left text-sm bg-slate-50 font-semibold text-slate-600">
                        <tr>
                            <td class="p-2 tracking-wide text-xs">Kode Barang</td>
                            <td class="p-2 tracking-wide text-xs">Nama Barang</td>
                            <td class="p-2 tracking-wide text-xs">Harga Pokok</td>
                            <td class="p-2 tracking-wide text-xs">Jumlah</td>
                            <td class="p-2 tracking-wide text-xs">Total Harga</td>
                            <td class="p-2 tracking-wide text-xs">Aksi</td>
                        </tr>
                    </thead>
                    <tbody id="purchase-details-table-body">
                        @if (isset($purchaseDetailsHtml))
                            {!! $purchaseDetailsHtml !!}
                        @endif
                    </tbody>
                </table>
            </div>

            <x-form.action :props="[
                'url' => route('purchase.index'),
            ]" />
        </form>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/function.js')
    <script type="module" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script type="module">
        {!! $validator !!}
    </script>
    <script type="module">
        $(document).on('click', '.save-row', function () {
            let btn = $(this);
            let id = btn.data('id');
            let stockId = btn.data('stock-id');
            let row = btn.closest('tr');
            let qty = row.find('.qty-input').val();

            btn.prop('disabled', true);

            $.ajax({
                url: "{{ route('purchase.update.item') }}",
                method: "POST",
                data: {
                    id: id,
                    stockId: stockId,
                    quantity: qty
                },
                success: function (res) {
                    row.find('.total-col').text('Rp ' + res.total_rp);

                    Swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: 'Berhasil memperbarui item!',
                        timer: 1200,
                        showConfirmButton: false
                    });

                    btn.prop('disabled', false);
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal update item.'
                    });

                    btn.prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.delete-item', function () {
            let icon = $(this);
            let id = icon.data('id');
            let stockId = icon.data('stock-id');
            let row = icon.closest('tr');

            Swal.fire({
                title: 'Hapus Item?',
                text: "Item ini akan dihapus dari daftar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1e293b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('purchase.delete.item') }}",
                        method: "POST",
                        data: {
                            id: id,
                            stockId: stockId
                        },
                        success: function (res) {
                            row.fadeOut(200, function () {
                                row.remove();
                            });

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Item berhasil dihapus.',
                                timer: 1200,
                                showConfirmButton: false
                            });
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus item.'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
