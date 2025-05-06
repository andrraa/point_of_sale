<label for="{{ $props['for'] }}" class="capitalize block mb-1 {{ $props['class'] ?? '' }}">
    {{ $props['label'] }}

    @if (isset($props['required']) && $props['required'])
        <span class="text-orange-500 font-bold">*</span>
    @endif
</label>
