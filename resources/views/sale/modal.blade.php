<div id="modal-sale-report" class="fixed inset-0 backdrop-blur-xs bg-gray-500/60 hidden justify-center items-center z-50">
    <div class="bg-white rounded-xl w-[450px] p-3">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold text-black/80 tracking-wide">
                Laporan Penjualan (PDF)
            </h2>

            <button class="text-lg font-bold text-gray-500 px-2 cursor-pointer modal-report-cancel">
                x
            </button>
        </div>

        <form id="form-report" action="{{ route('sale.report') }}" method="POST">
            @csrf

            <div class="mb-1">
                <label for="type_category"
                    class="font-medium text-sm text-gray-500 tracking-wide block mb-1">Tipe</label>
                <select name="type_category" id="type_category"
                    class="w-full px-4 py-1.5 rounded-lg border border-gray-300 shadow-sm text-sm outline-none cursor-pointer">
                    <option value="1">Detail</option>
                    <option value="2">Umum</option>
                </select>
            </div>

            <div class="mb-1">
                <label for="stock_category" class="font-medium text-sm text-gray-500 tracking-wide block mb-1">
                    Kategori
                </label>

                <select name="stock_category" id="stock_category"
                    class="w-full px-4 py-1.5 rounded-lg border border-gray-300 shadow-sm text-sm outline-none cursor-pointer">
                    <option value="all">Semua Kategori</option>
                    @foreach ($categories as $key => $category)
                        <option value="{{ $key }}">({{ $key }}) {{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label for="start_date" class="font-medium text-sm text-gray-500 tracking-wide mb-1">
                    Tanggal Mulai
                </label>

                <input type="date" id="start_date" name="start_date"
                    class="text-black/80 font-semibold tracking-wide px-4 py-1.5 rounded-lg border border-gray-300 shadow-sm text-sm w-full outline-none"
                    value="{{ $today }}">
            </div>

            <div class="mb-4">
                <label for="end_date" class="font-medium text-sm text-gray-500 tracking-wide block mb-1">
                    Tanggal Akhir
                </label>

                <input type="date" id="end_date" name="end_date"
                    class="text-black/80 font-semibold tracking-wide px-4 py-1.5 rounded-lg border border-gray-300 shadow-sm text-sm w-full outline-none"
                    value="{{ $today }}">
            </div>

            <div class="flex items-center gap-2 mt-4">
                <button type="button"
                    class="modal-report-cancel w-full py-1.5 text-sm border border-gray-300 rounded-lg text-black/80 tracking-wide font-semibold cursor-pointer hover:bg-gray-100 transition-colors duration-300">
                    Batal
                </button>
                <button type="submit"
                    class="w-full py-1.5 text-sm bg-blue-500 rounded-lg text-white tracking-wide font-semibold cursor-pointer hover:bg-blue-600 transition-colors duration-300">
                    Export
                </button>
            </div>
        </form>
    </div>
</div>
