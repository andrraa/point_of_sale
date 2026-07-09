<tr class="border-b border-slate-100">
    <td class="text-sm p-2 font-semibold text-slate-800">
        {{ $data['code'] }}
        <input type="hidden" name="purchase_items[{{ $index }}][id]" value="{{ $data['id'] }}">
        <input type="hidden" name="purchase_items[{{ $index }}][code]" value="{{ $data['code'] }}">
    </td>
    <td class="text-sm p-2 text-slate-700 line-clamp-1">{{ $data['name'] }}</td>
    <td class="text-sm p-2 text-slate-700">
        Rp {{ number_format($data['price']) }}
        <input type="hidden" name="purchase_items[{{ $index }}][price]" value="{{ $data['price'] }}">
    </td>
    <td class="text-sm p-2 text-slate-700">
        {{ $data['quantity'] }} pcs
        <input type="hidden" name="purchase_items[{{ $index }}][quantity]" value="{{ $data['quantity'] }}">
    </td>
    <td class="text-sm p-2 text-slate-700">Rp {{ number_format($data['total']) }}</td>
    <td class="text-sm p-2 delete-row">
        <i class="fa-solid fa-trash text-red-400 hover:text-red-600 cursor-pointer transition-colors"></i>
    </td>
</tr>
