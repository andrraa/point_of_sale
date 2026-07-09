@if (!empty($customer))
    <div class="mt-4 rounded-lg border border-slate-200 py-3 px-4">
        @forelse ($customer->credits as $credit)
            <div class="tracking-wide text-red-700 font-medium border-b border-slate-200 pb-2 mb-2 text-sm">
                <h2>Riwayat Hutang {{ $customer->customer_name }}</h2>
            </div>
            <div class="flex items-center justify-between mt-1">
                <div class="font-medium text-sm tracking-wide text-slate-700">
                    <h2>Invoice: {{ $credit->customer_credit_invoice }}</h2>
                </div>
                <div class="font-medium text-sm tracking-wide text-slate-700">
                    <h2>Rp {{ number_format($credit->customer_credit) }}</h2>
                </div>
            </div>
        @empty
            <div class="tracking-wide text-slate-600 font-medium text-sm">
                <h2>Pelanggan "{{ $customer->customer_name }}" tidak memiliki hutang.</h2>
            </div>
        @endforelse
    </div>
@endif
