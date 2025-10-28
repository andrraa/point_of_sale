<ul class="divide-y divide-gray-200 text-left">
    @foreach ($results as $item)
        <li class="p-2 cursor-pointer hover:bg-gray-100 search-result-item"
            data-code="{{ $item->stock_code }}">
            <div class="flex justify-between">
                <div>
                    <strong>{{ $item->stock_name }}</strong>
                    <div class="text-xs text-gray-500">{{ $item->stock_code }}</div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
