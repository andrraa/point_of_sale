{{-- TAKEN MODAL --}}
<div id="modal-taken"
    class="fixed inset-0 backdrop-blur-xs bg-gray-500/60 hidden justify-center items-center z-50">
    <div class="bg-white rounded-xl w-[500px] p-5 shadow-xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
            <h2 class="text-base font-semibold text-slate-800">Pengambilan Stok</h2>
            <button class="text-lg font-bold text-slate-400 px-2 cursor-pointer taken-cancel hover:text-slate-600 transition-colors">x</button>
        </div>

        <form id="form-taken" action="{{ route('stock.taken.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="stock_taken_stock_id" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Barang <span class="text-red-500">*</span>
                </label>
                <select name="stock_taken_stock_id" id="stock_taken_stock_id"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none">
                    <option value="">Pilih Barang</option>
                    @foreach ($stocks as $stock)
                        <option value="{{ $stock->stock_id }}">
                            {{ $stock->stock_code }} - {{ $stock->stock_name }} (Stok: {{ $stock->stock_total }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="stock_taken_quantity" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Jumlah <span class="text-red-500">*</span>
                </label>
                <input type="text" name="stock_taken_quantity" id="stock_taken_quantity"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none number-input"
                    placeholder="Masukkan jumlah">
            </div>

            <div class="mb-4">
                <label for="stock_taken_price" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Harga
                </label>
                <input type="text" name="stock_taken_price" id="stock_taken_price"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none price-input"
                    placeholder="Masukkan harga (jika ada)">
            </div>

            <div class="mb-4">
                <label for="stock_taken_description" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Deskripsi <span class="text-red-500">*</span>
                </label>
                <textarea name="stock_taken_description" id="stock_taken_description"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none resize-none"
                    rows="3" placeholder="Masukkan deskripsi pengambilan"></textarea>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-4 border-t border-slate-200">
                <button type="button"
                    class="taken-cancel w-full py-2 text-sm border border-slate-300 rounded-lg text-slate-600 font-medium cursor-pointer hover:bg-slate-100 transition-colors duration-200">
                    Batal
                </button>
                <button type="submit"
                    class="w-full py-2 text-sm bg-slate-800 rounded-lg text-white font-medium cursor-pointer hover:bg-slate-700 transition-colors duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- REPORT MODAL --}}
<div id="modal-taken-report"
    class="fixed inset-0 backdrop-blur-xs bg-gray-500/60 hidden justify-center items-center z-50">
    <div class="bg-white rounded-xl w-[450px] p-5 shadow-xl">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
            <h2 class="text-base font-semibold text-slate-800">Laporan Pengambilan Stok</h2>
            <button class="text-lg font-bold text-slate-400 px-2 cursor-pointer taken-report-cancel hover:text-slate-600 transition-colors">x</button>
        </div>

        <form id="form-taken-report" action="{{ route('stock.taken.report') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none"
                    value="{{ $today }}">
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Akhir</label>
                <input type="date" name="end_date" id="end_date"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none"
                    value="{{ $today }}">
            </div>

            <div class="flex items-center gap-3 mt-6 pt-4 border-t border-slate-200">
                <button type="button"
                    class="taken-report-cancel w-full py-2 text-sm border border-slate-300 rounded-lg text-slate-600 font-medium cursor-pointer hover:bg-slate-100 transition-colors duration-200">
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
