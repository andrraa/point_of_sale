<ul class="divide-y divide-slate-200 text-left">
    @foreach ($results as $item)
        <li class="p-2 cursor-pointer hover:bg-slate-100 search-result-item transition-colors"
            data-code="{{ $item->stock_code }}">
            <div class="flex justify-between">
                <div>
                    <strong class="text-slate-700 text-sm">{{ $item->stock_name }}</strong>
                    <div class="text-xs text-slate-400">{{ $item->stock_code }}</div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
