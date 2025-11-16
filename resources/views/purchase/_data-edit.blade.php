<tr class="border-b border-b-gray-200">
    <td class="text-sm p-2 font-semibold text-blue-500">
        {{ $data['code'] }}
        <input type="hidden" name="purchase_items[{{ $index }}][id]" value="{{ $data['id'] }}">
        <input type="hidden" name="purchase_items[{{ $index }}][code]" value="{{ $data['code'] }}">
    </td>

    <td class="text-sm p-2 line-clamp-1">
        {{ $data['name'] }}
    </td>

    <td class="text-sm p-2">
        Rp {{ number_format($data['price']) }}
        <input type="hidden" name="purchase_items[{{ $index }}][price]" value="{{ $data['price'] }}">
    </td>

    <td class="text-sm p-2">
        <input 
            type="text" 
            class="qty-input border border-gray-200 focus:border-blue-500 outline-none p-1 rounded w-16"
            data-id="{{ $data['purchase_id'] }}"
            data-price="{{ $data['price'] }}"
            name="purchase_items[{{ $index }}][quantity]" 
            value="{{ $data['quantity'] }}">
    </td>

    <td class="text-sm p-2 total-col">
        Rp {{ number_format($data['total']) }}
    </td>

    <td class="text-sm p-2 flex items-center gap-3">
        <button
            type="button"
            class="save-row text-blue-500 cursor-pointer py-1"
            data-stock-id="{{ $data['id'] }}"
            data-id="{{ $data['purchase_id'] }}">
            <i class="fa-solid fa-save"></i>
        </button>

        <i 
            class="fa-solid fa-trash text-red-500 cursor-pointer delete-item" 
            data-id="{{ $data['purchase_id'] }}"
            data-stock-id="{{ $data['id'] }}">
        </i>
    </td>
</tr>
