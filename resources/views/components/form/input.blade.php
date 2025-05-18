<input type="{{ $props['type'] ?? 'text' }}"" id="{{ $props['id'] }}" name="{{ $props['name'] }}"
    class="px-4 py-[10px] rounded-md outline-none border border-gray-200 w-full focus:border-blue-900 {{ isset($props['class']) ? $props['class'] : '' }}"
    value="{{ $props['value'] ?? null }}" placeholder="{{ $props['placeholder'] ?? '' }}" autocomplete="off"
    {{ isset($props['readonly']) && $props['readonly'] ? 'readonly' : '' }}>
