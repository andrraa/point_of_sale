@extends('layouts.app')

@section('title', 'Pelanggan')

@section('navTitle', 'Detail Pelanggan')

@section('content')
    <div class="mb-6 w-fit">
        <a href="{{ route('customer.index') }}"
            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm bg-white border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors duration-200 text-slate-600">
            <i class="fa-solid fa-chevron-left text-xs"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        {{-- HEADER --}}
        <div class="px-6 py-5 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center">
                    <i class="fa-solid fa-user text-slate-600 text-sm"></i>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-slate-800">Detail Pelanggan</h2>
                    <p class="text-xs text-slate-500">{{ $customer->customer_name }}</p>
                </div>
            </div>
        </div>

        {{-- BODY --}}
        <div class="p-6">
            <div class="grid grid-cols-2 gap-6 mb-8">
                <div>
                    <table class="w-full text-sm">
                        <tr>
                            <td class="py-1.5 text-slate-500 w-[140px]">Nama</td>
                            <td class="py-1.5 text-slate-700 font-medium">{{ $customer->customer_name }}</td>
                        </tr>
                        <tr>
                            <td class="py-1.5 text-slate-500">Kategori</td>
                            <td class="py-1.5 text-slate-700">{{ $customer->category->category_code }} - {{ $customer->category->category_name }}</td>
                        </tr>
                        <tr>
                            <td class="py-1.5 text-slate-500">Alamat</td>
                            <td class="py-1.5 text-slate-700">{{ $customer->customer_address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-1.5 text-slate-500">Wilayah</td>
                            <td class="py-1.5 text-slate-700">{{ $customer->region->region_code }} - {{ $customer->region->region_name }}</td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table class="w-full text-sm">
                        <tr>
                            <td class="py-1.5 text-slate-500 w-[140px]">No. Handphone</td>
                            <td class="py-1.5 text-slate-700">{{ $customer->customer_phone_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-1.5 text-slate-500">No. NPWP</td>
                            <td class="py-1.5 text-slate-700">{{ $customer->customer_npwp_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-1.5 text-slate-500">Status</td>
                            <td class="py-1.5">
                                @if ($customer->customer_status == 1)
                                    <span class="text-xs py-0.5 px-2 font-medium rounded-md text-white bg-emerald-500">Aktif</span>
                                @else
                                    <span class="text-xs py-0.5 px-2 font-medium rounded-md text-white bg-slate-400">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- CREDIT HISTORY --}}
            <div class="mb-4 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-credit-card text-slate-400 text-sm"></i>
                    <h3 class="text-sm font-semibold text-slate-700">Riwayat Hutang / Kredit</h3>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="p-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50">#</th>
                            <th class="p-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50">Invoice</th>
                            <th class="p-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50">Total Hutang</th>
                            <th class="p-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50">Status</th>
                            <th class="p-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50">Tanggal Bayar</th>
                            <th class="p-2.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                            $total = 0;
                        @endphp

                        @forelse ($customer->credits as $index => $credit)
                            <tr>
                                <td class="p-2.5 text-slate-600">{{ $index + 1 }}</td>
                                <td class="p-2.5 font-medium text-slate-800">{{ $credit->customer_credit_invoice }}</td>
                                <td class="p-2.5 text-slate-700">Rp {{ number_format($credit->customer_credit, 0, ',', '.') }}</td>
                                <td class="p-2.5">
                                    @if ($credit->customer_credit_status != \App\Models\CustomerCredit::UNPAID_STATUS)
                                        <span class="text-xs py-0.5 px-2 rounded-md bg-emerald-500 text-white font-medium">LUNAS</span>
                                    @else
                                        <span class="text-xs py-0.5 px-2 rounded-md bg-amber-500 text-white font-medium">BELUM LUNAS</span>
                                    @endif
                                </td>
                                <td class="p-2.5 text-slate-600">
                                    @if ($credit->customer_credit_status == \App\Models\CustomerCredit::UNPAID_STATUS)
                                        <span class="text-slate-400">-</span>
                                    @else
                                        {{ $credit->customer_credit_payment_date }}
                                    @endif
                                </td>
                                <td class="p-2.5">
                                    @if ($credit->customer_credit_status == \App\Models\CustomerCredit::UNPAID_STATUS)
                                        <button title="Lunasi Hutang" type="button"
                                            class="creditPayment px-2 py-1 border rounded-md border-emerald-500 cursor-pointer hover:bg-emerald-500 hover:text-white text-emerald-500 transition-all duration-200 text-xs"
                                            data-id="{{ $credit->customer_credit_id }}">
                                            <i class="fa-solid fa-check"></i> Bayar
                                        </button>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>

                            @php
                                $total += $credit->customer_credit;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="6" class="p-3 text-sm text-slate-500 text-center">Tidak ada data hutang / kredit.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($customer->credits->isNotEmpty())
                        <tfoot>
                            <tr class="border-t border-slate-200">
                                <td colspan="2" class="p-2.5 text-xs font-semibold text-slate-600 bg-slate-50 text-center">Total</td>
                                <td class="p-2.5 text-sm font-semibold text-slate-800 bg-slate-50">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                <td colspan="3" class="p-2.5 bg-slate-50"></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function () {
            $(document).on('click', '.creditPayment',
                function () {
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
                                success: function (result) {
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
