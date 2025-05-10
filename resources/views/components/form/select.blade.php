<select name="{{ $props['name'] }}" id="{{ $props['id'] }}" class="select2 {{ $props['class'] ?? '' }}">
    @isset($options)
        @foreach ($options as $key => $value)
            <option value="{{ $key }}" {{ $key == $props['value'] ? 'selected' : '' }} class="text-sm tracking-wide">
                {{ $value }}
            </option>
        @endforeach
    @else
        <option value="">Tidak ada pilihan yang tersedia</option>
    @endisset
</select>
