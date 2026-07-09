<textarea 
    name="{{ $props['name'] }}" 
    id="{{ $props['id'] }}" 
    class="{{ $props['class'] ?? '' }} w-full resize-none outline-none border border-gray-200 rounded-md px-4 py-[10px] focus:border-slate-500"
    rows="5"
    placeholder="{{ $props['placeholder'] ?? '' }}">{{ $props['value'] ?? '' }}</textarea>