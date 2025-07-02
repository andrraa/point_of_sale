@if (!empty($customer))
    <div class="mt-4 rounded-lg border border-gray-200 py-2 px-4">
        @forelse ($customer->credits as $credit)
            <div class="tracking-wide text-red-900 font-medium border-b border-b-gray-200 pb-1 mb-1 text-sm">
                <h2>Riwayat Hutang {{ $customer->customer_name }}</h2>
            </div>
            <div class="flex items-center justify-between mt-1">
                <div class="font-medium text-[14px] tracking-wide text-blue-500 text-sm">
                    <h2>Invoice: {{ $credit->customer_credit_invoice }}</h2>
                </div>
                <div class="font-medium text-[14px] tracking-wide text-blue-500 text-sm">
                    <h2>Rp {{ number_format($credit->customer_credit) }}</h2>
                </div>
            </div>
        @empty
            <div class="tracking-wide text-blue-500 font-medium mb-1 text-sm">
                <h2>Pelanggan "{{ $customer->customer_name }}" tidak memiliki hutang.</h2>
            </div>
        @endforelse
    </div>
@endif
