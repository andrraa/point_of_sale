<div class="text-center">
    <h2 class="text-[10px] tracking-wider uppercase">{{ $store->store_name }}</h2>
    <h2 class="text-[10px] tracking-wider uppercase">{{ $store->store_address }}</h2>
    <h2 class="text-[10px] tracking-wider">{{ $store->store_phone_number }}</h2>
</div>

<div class="w-full border-t border-dashed border-black my-1"></div>

<table class="w-full">
    <tr>
        <td class="text-[10px] tracking-wider uppercase">Invoice:</td>
    </tr>
    <tr>
        <td class="text-[10px] tracking-wider uppercase">{{ $sale->sales_invoice }}</td>
    </tr>

    <tr>
        <td class="py-0.5"></td>
    </tr>

    <tr>
        <td class="text-[10px] tracking-wider uppercase">Tanggal:</td>
    </tr>
    <tr>
        <td class="text-[10px] tracking-wider uppercase">{{ $sale->formatted_created_at }}</td>
    </tr>

    <tr>
        <td class="py-0.5"></td>
    </tr>

    <tr>
        <td class="text-[10px] tracking-wider uppercase">Kasir:</td>
    </tr>
    <tr>
        <td class="text-[10px] tracking-wider uppercase">{{ Session::get('user')['username'] }}</td>
    </tr>

    <tr>
        <td class="py-0.5"></td>
    </tr>

    <tr>
        <td class="text-[10px] tracking-wider uppercase">Pembayaran:</td>
    </tr>
    <tr>
        <td class="text-[10px] tracking-wider uppercase">
            {{ $sale->sales_status == \App\Models\Sale::PAID_STATUS ? 'Kontan' : 'Kredit/Tempo' }}
        </td>
    </tr>

    <tr>
        <td class="py-0.5"></td>
    </tr>

    <tr>
        <td class="text-[10px] tracking-wider uppercase">Pelanggan:</td>
    </tr>
    <tr>
        <td class="text-[10px] tracking-wider uppercase">{{ $sale->customer->customer_name }}</td>
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
            <div class="text-[10px] tracking-wider uppercase">
                {{ $item->sale_detail_stock_name }}
            </div>
            <div class="text-[10px] tracking-wider uppercase">
                {{ $quantity }}pcs {{ '@' . number_format($price) }} : {{ number_format($quantity * $price) }}
            </div>
        </div>
    </div>

    @php
        $totalDiscount += $item->sale_detail_discount_amount;
    @endphp
@endforeach

<div class="w-full border-t border-dashed border-black my-1"></div>

<div class="flex flex-col">
    <h2 class="text-[10px] tracking-wider uppercase">
        Subtotal: {{ number_format($sale->sales_total_gross) }}
    </h2>

    <h2 class="text-[10px] tracking-wider uppercase">
        Diskon: {{ number_format($totalDiscount) }}
    </h2>

    <h2 class="text-[10px] tracking-wider uppercase">
        Total Bayar: {{ number_format($sale->sales_total_payment) }}
    </h2>

    <h2 class="text-[10px] tracking-wider uppercase">
        Total Kembalian: {{ number_format($sale->sales_total_change) }}
    </h2>
</div>

<div class="w-full border-t border-dashed border-black my-1"></div>

<div class="text-center">
    <h2 class="text-[10px] tracking-wider uppercase">Terbayar {{ $sale->formatted_created_at }}</h2>
    <h2 class="text-[10px] tracking-wider uppercase">
        dicetak oleh: {{ Session::get('user')['username'] }}
    </h2>
</div>

<div class="text-center mt-2">
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($sale->sales_invoice, 'C128', 3, 70) }}" alt="barcode" />
</div>

<div class="flex flex-col items-center mt-4 gap-2">
    <button type="button" id="cancel-print-button"
        class="no-print w-full py-2 rounded-lg text-sm transition duration-200 tracking-wide cursor-pointer font-medium border border-gray-300 hover:bg-gray-100">
        Tutup
    </button>

    <button type="button" id="print-button"
        class="no-print w-full py-2 rounded-lg bg-blue-500 text-white text-sm hover:bg-blue-950 transition duration-200 tracking-wide cursor-pointer font-medium">
        Cetak
    </button>
</div>
