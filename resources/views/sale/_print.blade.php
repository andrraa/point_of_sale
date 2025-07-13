<div class="text-center">
    <h2 class="text-[8px] tracking-wider uppercase">{{ $store->store_name }}</h2>
    <h2 class="text-[8px] tracking-wider uppercase">{{ $store->store_address }}</h2>
    <h2 class="text-[8px] tracking-wider">{{ $store->store_phone_number }}</h2>
</div>

<div class="w-full border-t border-dashed border-black my-1"></div>

<table class="w-full">
    <tr>
        <td class="text-[8px] tracking-wider uppercase">Invoice</td>
        {{-- <td class="text-[8px] tracking-wider uppercase">{{ $sale->sales_invoice }}</td> --}}
    </tr>
    <tr>
        <td class="text-[8px] tracking-wider uppercase">{{ $sale->sales_invoice }}</td>
    </tr>
    <tr>
        <td class="text-[8px] tracking-wider uppercase">Tanggal</td>
        <td class="text-[8px] tracking-wider uppercase">{{ $sale->created_at }}</td>
    </tr>
    <tr>
        <td class="text-[8px] tracking-wider uppercase">Kasir</td>
        <td class="text-[8px] tracking-wider uppercase">Admin</td>
    </tr>
    <tr>
        <td class="text-[8px] tracking-wider uppercase">Jenis Order</td>
        <td class="text-[8px] tracking-wider uppercase">
            {{ $sale->sales_status == \App\Models\Sale::PAID_STATUS ? 'Kontan' : 'Kredit/Tempo' }}</td>
    </tr>
    <tr>
        <td class="text-[8px] tracking-wider uppercase">Nama Pelanggan</td>
        <td class="text-[8px] tracking-wider uppercase">{{ $sale->customer->customer_name }}</td>
    </tr>
</table>

<div class="w-full border-t border-dashed border-black my-1"></div>

@php
    $totalDiscount = 0;
@endphp

@foreach ($sale->details as $item)
    <div class="flex items-center justify-between">
        @php
            $quantity = $item->sale_detail_quantity;
            $price = $item->sale_detail_price;
        @endphp
        <div class="flex flex-col">
            <div class="text-[8px] tracking-wider uppercase">
                {{ $item->sale_detail_stock_name }}
            </div>
            <div class="text-[8px] tracking-wider uppercase">
                {{ $quantity }}pcs {{ '@' . number_format($price) }}
            </div>
        </div>
        <div class="shrink-0">
            <h2 class="text-[8px] tracking-wider">{{ number_format($quantity * $price) }}</h2>
        </div>
    </div>

    @php
        $totalDiscount += $item->sale_detail_discount_amount;
    @endphp
@endforeach

<div class="w-full border-t border-dashed border-black my-1"></div>

<div class="flex flex-col">
    <div class="flex flex-col">
        <h2 class="text-[8px] tracking-wider uppercase">Subtotal</h2>
        <span class="text-[8px]">{{ number_format($sale->sales_total_gross) }}</span>
    </div>

    <div class="flex flex-col">
        <h2 class="text-[8px] tracking-wider uppercase">Diskon</h2>
        <span class="text-[8px]">{{ number_format($totalDiscount) }}</span>
    </div>

    <div class="flex flex-col">
        <h2 class="text-[8px] tracking-wider uppercase">Total Bayar</h2>
        <span class="text-[8px]">{{ number_format($sale->sales_total_payment) }}</span>
    </div>

    <div class="flex flex-col">
        <h2 class="text-[8px] tracking-wider uppercase">Total Kembalian</h2>
        <span class="text-[8px]">{{ number_format($sale->sales_total_change) }}</span>
    </div>
</div>

<div class="w-full border-t border-dashed border-black my-1"></div>

<div class="text-center">
    <h2 class="text-[8px] tracking-wider uppercase">Terbayar 24 Mei 2025 12:32</h2>
    <h2 class="text-[8px] tracking-wider uppercase">dicetak oleh: Admin</h2>
</div>

<div class="text-center mt-2">
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($sale->sales_invoice, 'C128', 3, 70) }}" alt="barcode" />
</div>

<div class="flex items-center gap-2">
    <button type="button" id="cancel-print-button"
        class="no-print w-full py-2 rounded-lg text-sm transition duration-200 tracking-wide mt-4 cursor-pointer font-medium border border-gray-300 hover:bg-gray-100">
        Tutup
    </button>

    <button type="button" id="print-button"
        class="no-print w-full py-2 rounded-lg bg-blue-500 text-white text-sm hover:bg-blue-950 transition duration-200 tracking-wide mt-4 cursor-pointer font-medium">
        Cetak
    </button>
</div>
