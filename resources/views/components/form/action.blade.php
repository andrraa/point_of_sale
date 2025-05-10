<div class="flex gap-2 justify-end">
    <a href="{{ $props['url'] }}">
        <div
            class="rounded-lg px-4 py-2 border outline-none border-gray-300 tracking-wide hover:bg-gray-200 w-fit transition duration-200">
            <span>{{ $props['cancelLabel'] ?? 'Batal' }}</span>
        </div>
    </a>
    <button type="submit"
        class="px-4 py-2 bg-blue-900 border rounded-lg outline-none tracking-wide text-white hover:border-blue-900 hover:bg-white hover:text-blue-900 cursor-pointer font-medium">
        {{ $props['submitLabel'] ?? 'Simpan' }}
    </button>
</div>
