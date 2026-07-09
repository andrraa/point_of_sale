<tr class="border-b border-slate-100">
    <td class="text-sm p-2 font-semibold text-slate-800">
        {{ $data['code'] }}
        <input type="hidden" name="purchase_items[{{ $index }}][id]" value="{{ $data['id'] }}">
        <input type="hidden" name="purchase_items[{{ $index }}][code]" value="{{ $data['code'] }}">
    </td>

    <td class="text-sm p-2 text-slate-700 line-clamp-1">
        {{ $data['name'] }}
    </td>

    <td class="text-sm p-2 text-slate-700">
        Rp {{ number_format($data['price']) }}
        <input type="hidden" name="purchase_items[{{ $index }}][price]" value="{{ $data['price'] }}">
    </td>

    <td class="text-sm p-2">
        <input
            type="text"
            class="qty-input border border-slate-300 focus:border-slate-500 outline-none px-2 py-1 rounded w-16 text-sm"
            data-id="{{ $data['purchase_id'] }}"
            data-price="{{ $data['price'] }}"
            name="purchase_items[{{ $index }}][quantity]"
            value="{{ $data['quantity'] }}">
    </td>

    <td class="text-sm p-2 total-col text-slate-700">
        Rp {{ number_format($data['total']) }}
    </td>

    <td class="text-sm p-2">
        <div class="flex items-center gap-3">
            <button
                type="button"
                class="save-row text-slate-800 hover:text-slate-900 cursor-pointer py-1 transition-colors"
                data-stock-id="{{ $data['id'] }}"
                data-id="{{ $data['purchase_id'] }}">
                <i class="fa-solid fa-save"></i>
            </button>

            <i
                class="fa-solid fa-trash text-red-400 hover:text-red-600 cursor-pointer delete-item transition-colors"
                data-id="{{ $data['purchase_id'] }}"
                data-stock-id="{{ $data['id'] }}">
            </i>
        </div>
    </td>
</tr>
