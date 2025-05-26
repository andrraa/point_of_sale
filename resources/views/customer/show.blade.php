@extends('layouts.app')

@section('title', 'Pelanggan')

@section('navTitle', 'Detail Pelanggan')

@section('content')
    <div class="bg-white rounded-lg px-4 py-6 border border-gray-200">
        {{-- CUSTOMER --}}
        <div class="mb-2 pb-2 border-b border-b-gray-200">
            <h2 class="text-sm tracking-wide text-blue-900 font-medium text-[15px]">Data Pelanggan</h2>
        </div>

        <table class="w-full mb-4">
            <tr>
                <td class="w-[240px] py-1">Nama</td>
                <td>:</td>
                <td>{{ $customer->customer_name }}</td>
            </tr>
            <tr>
                <td class="w-[240px] py-1">Kategori</td>
                <td>:</td>
                <td>{{ $customer->category->category_code }} - {{ $customer->category->category_name }}</td>
            </tr>
            <tr>
                <td class="w-[240px] py-1">Alamat</td>
                <td>:</td>
                <td>{{ $customer->customer_address }}</td>
            </tr>
            <tr>
                <td class="w-[240px] py-1">Wilayah</td>
                <td>:</td>
                <td>{{ $customer->region->region_code }} - {{ $customer->region->region_name }}</td>
            </tr>
            <tr>
                <td class="w-[240px] py-1">Nomor Handphone</td>
                <td>:</td>
                <td>{{ $customer->customer_phone_number }}</td>
            </tr>
            <tr>
                <td class="w-[240px] py-1">Nomor NPWP</td>
                <td>:</td>
                <td>{{ $customer->customer_npwp_number }}</td>
            </tr>
        </table>

        {{-- CREDIT --}}
        <div class="mb-4 pb-2 border-b border-b-gray-200">
            <h2 class="text-sm tracking-wide text-blue-900 font-medium text-[15px]">Riwayat Credit / Hutang</h2>
        </div>

        <table class="w-full mb-6">
            <thead>
                <tr class="border-b border-b-gray-200">
                    <th class="p-2 text-left text-sm tracking-wider bg-gray-100">#</th>
                    <th class="p-2 text-left text-sm tracking-wider bg-gray-100">Invoice</th>
                    <th class="p-2 text-left text-sm tracking-wider bg-gray-100">Total Hutang</th>
                    <th class="p-2 text-left text-sm tracking-wider bg-gray-100">Status</th>
                    <th class="p-2 text-left text-sm tracking-wider bg-gray-100">Tanggal Bayar</th>
                    <th class="p-2 text-left text-sm tracking-wider bg-gray-100">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($customer->credits as $index => $credit)
                    <tr>
                        <td class="p-2 text-sm text-gray-900 text-left">
                            {{ $index + 1 }}
                        </td>
                        <td class="p-2 text-sm text-left font-medium text-blue-900">
                            {{ $credit->customer_credit_invoice }}
                        </td>
                        <td class="p-2 text-sm text-gray-900 font-medium text-left">
                            Rp {{ number_format($credit->customer_credit) }}
                        </td>
                        <td class="p-2 text-sm text-gray-900 text-left">
                            @if ($credit->customer_credit_status != \App\Models\CustomerCredit::UNPAID_STATUS)
                                <span
                                    class="text-xs tracking-wider font-bold border-2 boder-md px-2 py-1 rounded-md bg-blue-900 text-white">
                                    LUNAS
                                </span>
                            @else
                                <span
                                    class="text-xs tracking-wider font-bold border-2 boder-md px-2 py-1 rounded-md bg-red-900 text-white">
                                    BELUM LUNAS
                                </span>
                            @endif
                        </td>
                        <td class="p-2 text-sm text-gray-900 text-left font-medium">
                            {{ $credit->customer_credit_payment_date ?? '-' }}
                        </td>
                        <td class="p-2 text-sm text-gray-900 text-left font-medium">
                            @if ($credit->customer_credit_status == \App\Models\CustomerCredit::UNPAID_STATUS)
                                <button title="Lunasi Hutang" type="button"
                                    class="creditPayment px-[6px] py-[2px] border rounded-md border-green-500 cursor-pointer hover:bg-green-500 hover:text-white text-green-500"
                                    data-id="{{ $credit->customer_credit_id }}">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-2 text-sm text-gray-900 text-left font-medium tracking-wide">
                            Tidak ada data hutang / credit.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('customer.index') }}"
            class="px-4 py-2 rounded-lg border border-gray-300 text-sm tracking-wide transition duration-200 hover:bg-gray-200">
            Kembali
        </a>
    </div>
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $(document).on('click', '.creditPayment',
                function() {
                    const creditId = $(this).data('id');

                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Apakah yakin ingin mengubah status menjadi lunas?',
                        showCancelButton: true,
                        cancelButtonText: 'Batal'
                    }).then((res) => {
                        if (res.isConfirmed) {
                            Swal.fire({
                                title: 'Memproses...',
                                text: 'Silakan tunggu sebentar',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            $.ajax({
                                url: "{{ route('customer.pay') }}",
                                type: "POST",
                                data: {
                                    creditId: creditId
                                },
                                success: function(result) {
                                    if (result) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Sukses',
                                            text: 'Status hutang berhasil diperbarui.'
                                        }).then((x) => {
                                            if (x.isConfirmed) {
                                                location.reload();
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    });
                });
        });
    </script>
@endpush
