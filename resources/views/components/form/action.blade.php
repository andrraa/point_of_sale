<div class="flex gap-2 justify-end mt-6 pt-4 border-t border-slate-200">
    <a href="{{ $props['url'] }}">
        <div
            class="rounded-lg px-4 py-2 border border-slate-300 text-slate-600 tracking-wide hover:bg-slate-100 w-fit transition-all duration-200 text-sm">
            <span>{{ $props['cancelLabel'] ?? 'Batal' }}</span>
        </div>
    </a>
    <button type="submit"
        class="px-4 py-2 bg-slate-800 border border-slate-800 rounded-lg tracking-wide text-white hover:bg-white hover:text-slate-800 cursor-pointer font-medium text-sm transition-all duration-200">
        {{ $props['submitLabel'] ?? 'Simpan' }}
    </button>
</div>
