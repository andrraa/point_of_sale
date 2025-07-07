<div id="modal-stock-taken" class="fixed inset-0 backdrop-blur-xs bg-gray-500/60 hidden justify-center items-center z-50">
    <div class="bg-white rounded-xl w-[450px] p-3">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold text-black/80 tracking-wide">
                Pengambilan Stok Baru
            </h2>

            <button class="text-lg font-bold text-gray-500 px-2 cursor-pointer modal-taken-cancel">
                x
            </button>
        </div>

        <form id="form-stock-taken" action="{{ route('stock.taken') }}" method="POST">
            @csrf

            <div class="mb-2">
                <label for="" class="font-medium text-sm text-gray-500 tracking-wide block mb-0.5">
                    Kode Stok
                </label>

                <input type="text" id="stock_code" name="stock_code"
                    class="text-black/80 font-semibold tracking-wide px-4 py-1.5 rounded-lg border border-gray-300 shadow-sm text-sm w-full outline-none">
                <span id="stock-detail" class="text-xs font-medium tracking-wide text-blue-500 hidden">
                    Stock: Baju Bagus
                </span>
            </div>

            <div class="mb-2">
                <label for="" class="font-medium text-sm text-gray-500 tracking-wide">
                    Jumlah (pcs)
                </label>
                <input type="number" id="quantity" name="quantity"
                    class="text-black/80 font-semibold tracking-wide px-4 py-1.5 rounded-lg border border-gray-300 shadow-sm text-sm w-full outline-none">
            </div>

            <div class="mb-4">
                <div class="mb-1">
                    <label for="" class="font-medium text-sm text-gray-500 tracking-wide block mb-0.5">
                        Keterangan
                    </label>
                    <textarea id="description" name="description"
                        class="text-black/80 font-semibold tracking-wide px-4 py-1.5 rounded-lg border border-gray-300 shadow-sm text-sm w-full outline-none"></textarea>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button
                    class="modal-taken-cancel w-full py-1.5 text-sm border border-gray-300 rounded-lg text-black/80 tracking-wide font-semibold cursor-pointer hover:bg-gray-100 transition-colors duration-300">
                    Batal
                </button>
                <button type="submit"
                    class="w-full py-1.5 text-sm bg-blue-500 rounded-lg text-white tracking-wide font-semibold cursor-pointer hover:bg-blue-600 transition-colors duration-300">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
