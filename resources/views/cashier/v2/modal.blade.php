<div id="modal-pay" class="fixed inset-0 backdrop-blur-xs bg-gray-500/60 hidden justify-center items-center z-50">

    <div class="bg-white rounded-xl w-[450px] p-5 shadow-xl">

        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
            <h2 class="text-base font-semibold text-slate-800">
                Pembayaran Detail
            </h2>

            <button class="text-lg font-bold text-slate-400 px-2 cursor-pointer modal-pay-cancel hover:text-slate-600 transition-colors">x</button>
        </div>

        <div class="mb-4">
            <h2 class="text-sm font-semibold text-slate-700 mb-2">Pelanggan</h2>

            <div class="mb-2">
                <label class="block text-sm text-slate-500 mb-1">Nama</label>
                <input type="text" id="modal-customer-name"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none text-slate-700 bg-slate-50"
                    readonly>
            </div>

            <div>
                <label class="block text-sm text-slate-500 mb-1">Hutang</label>
                <input type="text" id="modal-customer-debt"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none text-slate-700 bg-slate-50"
                    readonly>
            </div>
        </div>

        <div class="mb-4">
            <h2 class="text-sm font-semibold text-slate-700 mb-2">Pembayaran</h2>

            <div class="mb-2">
                <label class="block text-sm text-slate-500 mb-1">Total Belanja</label>
                <input type="text" id="modal-customer-total"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none text-slate-700 bg-slate-50"
                    readonly>
            </div>

            <div class="flex items-center gap-2">
                <div class="flex-1">
                    <label class="block text-sm text-slate-500 mb-1">Total Bayar</label>
                    <input type="text" id="modal-customer-pay"
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none price-input">
                </div>

                <div class="flex-1">
                    <label class="block text-sm text-slate-500 mb-1">Total Kembalian</label>
                    <input type="text" id="modal-customer-change"
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm outline-none text-slate-700 bg-slate-50"
                        readonly>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-6 pt-4 border-t border-slate-200">
            <button
                class="modal-pay-cancel w-full py-2 text-sm border border-slate-300 rounded-lg text-slate-600 font-medium cursor-pointer hover:bg-slate-100 transition-colors duration-200">
                Batal
            </button>
            <button id="modal-pay-confirm"
                class="w-full py-2 text-sm bg-slate-800 rounded-lg text-white font-medium cursor-pointer hover:bg-slate-700 transition-colors duration-200">
                Bayar
            </button>
        </div>
    </div>
</div>
