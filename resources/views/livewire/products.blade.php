<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>

    {{-- Filter --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <input type="text" wire:model.live="search" placeholder="Cari produk..." class="border px-3 py-2 rounded w-full" />

        <select wire:model.live="category" class="border px-3 py-2 rounded w-full">
            <option value="">Semua Kategori</option>
            @foreach (\App\Models\Category::all() as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>

        <input type="number" wire:model.live="minPrice" placeholder="Harga Min" class="border px-3 py-2 rounded w-full" />

        <input type="number" wire:model.live="maxPrice" placeholder="Harga Max" class="border px-3 py-2 rounded w-full" />
    </div>

    {{-- Tabel Produk --}}
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">Kategori</th>
                <th class="border px-4 py-2">Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td class="border px-4 py-2">{{ $product->name }}</td>
                    <td class="border px-4 py-2">{{ $product->category->name ?? '-' }}</td>
                    <td class="border px-4 py-2">Rp {{ number_format($product->price) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4">Tidak ada produk ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
