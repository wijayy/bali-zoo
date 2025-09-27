<x-auth-layout title="Products">
    <div class="justify-end flex">
        <flux:button variant="primary" as href="{{ route('products.create') }}">Add Product</flux:button>
    </div>
    <div class="overflow-x-auto mt-4 text-xs md:text-sm">
        <div class=" w-full min-w-3xl">
            <div class="flex gap-2 py-2 lg:gap-4 w-full text-black dark:text-white items-center">
                <div class="w-10 text-center">#</div>
                <div class="w-1/4 text-wrap">Product Name</div>
                <div class="w-52 text-nowrap">Supplier</div>
                <div class="w-40 text-nowrap">Category</div>
                <div class="w-48 text-center">Price</div>
                <div class="w-40 text-center">Stock</div>
                <div class="text-center w-64">Actions</div>
            </div>
            @foreach ($products as $key => $item)
                <div class="flex gap-2 last:border-b border-black text-black dark:text-white py-2 lg:gap-4 w-full items-center">
                    <div class="text-center w-10">{{ $key + 1 }} </div>
                    <div class="w-1/4 text-wrap">
                        {{ $item->name }}
                    </div>
                    <div class="w-52 text-nowrap ">{{ $item->supplier->name }}
                    </div>
                    <div class="w-40  ">{{ $item->category->name }} </div>
                    <div class="w-48 text-nowrap text-center">IDR {{ number_format($item->price, 0, ',', '.') }} </div>
                    <div class="w-40 text-nowrap text-center">{{ $item->stock }} Pcs </div>

                    <div class="text-center flex-nowrap justify-center flex w-64 gap-2">
                        <flux:button as href="{{ route('shop.show', $item->slug) }}" icon="eye" size="sm" variant="primary" color="cyan">
                        </flux:button>
                        <flux:button as href="{{ route('products.edit', $item->slug) }}" variant="primary" color="emerald" icon="pencil-square"
                            size="sm"></flux:button>
                        <flux:modal.trigger name="delete-{{ $key }}">
                            <flux:button icon="trash" size="sm" variant="primary" color="rose">
                            </flux:button>
                        </flux:modal.trigger>
                        <flux:modal name="delete-{{ $key }}">
                            <form action="{{ route('products.destroy', ['product' => $item->slug]) }}" method="post">
                                @csrf
                                @method('delete')
                                <x-button class="pb-0! border-b! hover:border-rose-400">
                                    Delete</x-button>

                            </form>
                        </flux:modal>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-4">{{ $products->links() }} </div>
</x-auth-layout>
