<div id="modal-stock-report"
    class="fixed inset-0 backdrop-blur-xs bg-gray-500/60 hidden justify-center items-center z-50">
    <div class="bg-white rounded-xl w-[450px] p-5 shadow-xl">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
            <h2 class="text-base font-semibold text-slate-800 tracking-wide">
                Laporan Stok (PDF)
            </h2>

            <button class="text-lg font-bold text-slate-400 px-2 cursor-pointer modal-stock-cancel hover:text-slate-600 transition-colors">
                x
            </button>
        </div>

        <form id="form-report" action="{{ route('stock.report') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="stock_category"
                    class="font-medium text-sm text-slate-700 tracking-wide block mb-1.5">
                    Kategori
                </label>

                <select name="stock_category" id="stock_category"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none">
                    @foreach ($categories as $key => $category)
                        <option value="{{ $key }}">({{ $key }}) {{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-3">
                <button type="button"
                    class="modal-stock-cancel w-full py-2 text-sm border border-slate-300 rounded-lg text-slate-600 tracking-wide font-medium cursor-pointer hover:bg-slate-100 transition-colors duration-200">
                    Batal
                </button>
                <button type="submit"
                    class="w-full py-2 text-sm bg-slate-800 rounded-lg text-white tracking-wide font-medium cursor-pointer hover:bg-slate-700 transition-colors duration-200">
                    Export
                </button>
            </div>
        </form>
    </div>
</div>
