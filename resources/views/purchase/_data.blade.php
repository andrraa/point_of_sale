<tr class="border-b border-b-gray-200">
    <td class="text-sm p-2 font-semibold text-blue-900">
        {{ $data['code'] }}
        <input type="hidden" name="items[][code]" value="{{ $data['code'] }}">
    </td>
    <td class="text-sm p-2 line-clamp-1">{{ $data['name'] }}</td>
    <td class="text-sm p-2">Rp {{ number_format($data['price']) }}</td>
    <td class="text-sm p-2">
        {{ $data['quantity'] }} pcs
        <input type="hidden" name="items[][quantity]" value="{{ $data['quantity'] }}">
    </td>
    <td class="text-sm p-2">Rp {{ number_format($data['total']) }}</td>
    <td class="text-sm p-2 delete-row">
        <i class="fa-solid fa-trash text-red-500 cursor-pointer"></i>
    </td>
</tr>
