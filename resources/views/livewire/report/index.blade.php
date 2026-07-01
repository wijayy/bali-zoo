<div class="p-6 space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Report</h1>
        <p class="text-sm text-zinc-500">Pilih report yang ingin dilihat dan dicetak.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('report.transaction') }}" wire:navigate
            class="block rounded-lg border border-zinc-200 bg-white p-5 transition hover:border-emerald-400 hover:shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="text-lg font-semibold text-zinc-900 dark:text-white">Transaction Report</div>
            <div class="mt-2 text-sm text-zinc-500">
                Report penjualan berdasarkan tanggal transaksi, termasuk customer, pengiriman, pembayaran, produk,
                subtotal, ongkir, diskon, dan total.
            </div>
            <div class="mt-4 text-sm font-medium text-emerald-600">Open report</div>
        </a>

        <a href="{{ route('report.purchase') }}" wire:navigate
            class="block rounded-lg border border-zinc-200 bg-white p-5 transition hover:border-emerald-400 hover:shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="text-lg font-semibold text-zinc-900 dark:text-white">Purchase Report</div>
            <div class="mt-2 text-sm text-zinc-500">
                Report pembelian barang berdasarkan purchase date, termasuk produk, supplier, kategori, quantity,
                harga beli, subtotal, dan total purchase.
            </div>
            <div class="mt-4 text-sm font-medium text-emerald-600">Open report</div>
        </a>
    </div>
</div>
