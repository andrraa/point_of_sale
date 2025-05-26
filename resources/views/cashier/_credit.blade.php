@if (!empty($customer))
    <div class="mt-4 rounded-lg border border-gray-200 p-4">
        <div class="tracking-wide text-red-900 font-medium border-b border-b-gray-200 pb-1 mb-1">
            <h2>Riwayat Hutang {{ $customer->customer_name }}</h2>
        </div>
        @foreach ($customer->credits as $credit)
            <div class="flex items-center justify-between mt-1">
                <div class="font-medium text-[14px] tracking-wide text-blue-900">
                    <h2>Invoice: {{ $credit->customer_credit_invoice }}</h2>
                </div>
                <div class="font-medium text-[14px] tracking-wide text-blue-900">
                    <h2>Rp {{ number_format($credit->customer_credit) }}</h2>
                </div>
            </div>
        @endforeach
    </div>
@endif
