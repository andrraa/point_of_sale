<div id="modal-sale-report" class="fixed inset-0 backdrop-blur-xs bg-gray-500/60 hidden justify-center items-center z-50">
    <div class="bg-white rounded-xl w-[450px] p-5 shadow-xl">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
            <h2 class="text-base font-semibold text-slate-800">Laporan Penjualan (PDF)</h2>
            <button class="text-lg font-bold text-slate-400 px-2 cursor-pointer modal-report-cancel hover:text-slate-600 transition-colors">x</button>
        </div>

        <form id="form-report" action="{{ route('sale.report') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="type_category" class="block text-sm font-medium text-slate-700 mb-1.5">Tipe</label>
                <select name="type_category" id="type_category"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none cursor-pointer">
                    <option value="1">Detail</option>
                    <option value="2">Umum</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="stock_category" class="block text-sm font-medium text-slate-700 mb-1.5">Kategori</label>

                <select name="stock_category" id="stock_category"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none cursor-pointer">
                    @foreach ($categories as $key => $category)
                        <option value="{{ $key }}">({{ $key }}) {{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="start_date" class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none"
                    value="{{ $today }}">
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Akhir</label>
                <input type="date" id="end_date" name="end_date"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none"
                    value="{{ $today }}">
            </div>

            <div class="flex items-center gap-3 mt-6 pt-4 border-t border-slate-200">
                <button type="button"
                    class="modal-report-cancel w-full py-2 text-sm border border-slate-300 rounded-lg text-slate-600 font-medium cursor-pointer hover:bg-slate-100 transition-colors duration-200">
                    Batal
                </button>
                <button type="submit"
                    class="w-full py-2 text-sm bg-slate-800 rounded-lg text-white font-medium cursor-pointer hover:bg-slate-700 transition-colors duration-200">
                    Export
                </button>
            </div>
        </form>
    </div>
</div>
