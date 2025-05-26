<div class="text-center">
    <h2 class="text-[12px] tracking-wider uppercase">Toko Mutiara Indah</h2>
    <h2 class="text-[12px] tracking-wider uppercase">JL. INDONESIA RAYA NOMOR 35, BANDAR LAMPUNG, LAMPUNG</h2>
    <h2 class="text-[12px] tracking-wider">081276374983</h2>
</div>

<div class="w-full border-t border-dashed border-black my-1"></div>

<table class="w-full">
    <tr>
        <td class="text-[12px] tracking-wider uppercase">Invoice</td>
        <td class="text-[12px] tracking-wider uppercase w-[10px]">:</td>
        <td class="text-[12px] tracking-wider uppercase">{{ $sale->sales_invoice }}</td>
    </tr>
    <tr>
        <td class="text-[12px] tracking-wider uppercase">Tanggal</td>
        <td class="text-[12px] tracking-wider uppercase w-[10px]">:</td>
        <td class="text-[12px] tracking-wider uppercase">{{ $sale->created_at }}</td>
    </tr>
    <tr>
        <td class="text-[12px] tracking-wider uppercase">Kasir</td>
        <td class="text-[12px] tracking-wider uppercase w-[10px]">:</td>
        <td class="text-[12px] tracking-wider uppercase">Admin</td>
    </tr>
    <tr>
        <td class="text-[12px] tracking-wider uppercase">Jenis Order</td>
        <td class="text-[12px] tracking-wider uppercase w-[10px]">:</td>
        <td class="text-[12px] tracking-wider uppercase">
            {{ $sale->sales_status == \App\Models\Sale::PAID_STATUS ? 'Kontan' : 'Kredit/Tempo' }}</td>
    </tr>
    <tr>
        <td class="text-[12px] tracking-wider uppercase">Nama Pelanggan</td>
        <td class="text-[12px] tracking-wider uppercase w-[10px]">:</td>
        <td class="text-[12px] tracking-wider uppercase">{{ $sale->customer->customer_name }}</td>
    </tr>
</table>

<div class="w-full border-t border-dashed border-black my-1"></div>

@foreach ($sale->details as $item)
    <div class="flex items-center justify-between">
        @php
            $quantity = $item->sale_detail_quantity;
            $price = $item->sale_detail_price;
        @endphp
        <div class="flex flex-col">
            <div class="text-[12px] tracking-wider uppercase">
                {{ $item->sale_detail_stock_name }}
            </div>
            <div class="text-[12px] tracking-wider uppercase">
                {{ $quantity }}pcs {{ '@' . number_format($price) }}
            </div>
        </div>
        <div class="shrink-0">
            <h2 class="text-[12px] tracking-wider">{{ number_format($quantity * $price) }}</h2>
        </div>
    </div>
@endforeach

<div class="w-full border-t border-dashed border-black my-1"></div>

<div class="flex flex-col">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-[12px] tracking-wider uppercase">Diskon</h2>
        </div>
        <div class="text-[12px] tracking-wider">
            {{ number_format($sale->sales_total_discount) }}
        </div>
    </div>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-[12px] tracking-wider uppercase">Total</h2>
        </div>
        <div class="text-[12px] tracking-wider">
            {{ number_format($sale->sales_total_price) }}
        </div>
    </div>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-[12px] tracking-wider uppercase">Total Bayar</h2>
        </div>
        <div class="text-[12px] tracking-wider">
            {{ number_format($sale->sales_total_payment) }}
        </div>
    </div>
</div>

<div class="w-full border-t border-dashed border-black my-1"></div>

<div class="text-center">
    <h2 class="text-[12px] tracking-wider uppercase">Terbayar 24 Mei 2025 12:32</h2>
    <h2 class="text-[12px] tracking-wider uppercase">dicetak oleh: Admin</h2>
</div>

<button type="button" id="print-button" onclick="window.print()"
    class="no-print w-full py-2 rounded-lg bg-blue-900 text-white text-sm hover:bg-blue-950 transition duration-200 tracking-wide mt-4 cursor-pointer font-medium">
    CETAK
</button>
