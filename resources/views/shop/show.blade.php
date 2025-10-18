<x-app-layout title="{{ $product->name }}">
    <div class="pt-16">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

        </div>
    </div>
    <div class="">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 flex flex-wrap-reverse relative sm:flex-nowrap gap-4">
            <div class="flex w-full aspect-square lg:w-1/3 sm:w-1/2 h-fit gap-4 sticky" x-data="{ image: '{{ asset('storage/' . $product->image1) }}' }">
                <div class="sr-only">image</div>
                <div class="w-1/4 flex justify-between flex-col gap-4">
                    @for ($i = 1; $i < 5; $i++)
                        @if ($product['image' . $i] ?? false)
                            <div class="bg-center cursor-pointer bg-no-repeat bg-cover aspect-square"
                                x-on:click="image = '{{ asset('storage/' . $product['image' . $i]) }}'"
                                style="background-image: url({{ asset('storage/' . $product['image' . $i]) }})">
                            </div>
                        @endif
                    @endfor
                </div>
                <div class="bg-center bg-no-repeat bg-cover aspect-square  w-3/4"
                    :style="'background-image: url(' + image + ')'">
                </div>
            </div>
            <div class="w-full sm:w-1/2 lg:w-2/3">
                <div class="sr-only">Description</div>
                <div class="text-xl lg:text-4xl">{{ $product->name }} </div>
                <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}"
                    class="text-sm mt-1 lg:text-lg border-b-2">{{ $product->category->name }} </a>
                <div class="text-gray-400 text-lg lg:text-2xl mt-4">IDR.
                    {{ number_format($product->price, 0, ',', '.') }} </div>
                <form action="{{ route('cart.store') }}" method="post" class="mt-8 flex gap-4 text-sm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="">
                        <flux:input wire:model.live="qty" type="number" value="1" class="w-12" min="1"
                            max="{{ $product->stock }}"></flux:input>
                    </div>
                    <flux:button variant='underline' type="submit" class="">Add to cart</flux:button>
                </form>

                <div class=" mt-4">{{ $product->description }}</div>
            </div>
        </div>
    </div>

    <flux:container>
        <div class="text-center mt-4 font-semibold text-lg">Complete the Collection</div>
        <div class="text-sm text-center">Pair your new favorite with other products from the same series.</div>
        <div class="grid grid-cols-2 mt-4 sm:grid-cols-3 md:grid-cols-4 gap-2 lg:gap-4">
            @foreach ($products as $item)
                <a href="{{ route('shop.show', ['shop' => $item->slug]) }}"
                    class="bg-white shadow-mine hover:scale-101 group/product">
                    <div class="bg-cover group-hover/product:bg-[length:120%] transition bg-no-repeat p-2 bg-center aspect-3/4 w-full"
                        style="background-image: url({{ asset("storage/$item->image1") }})">
                        <div class="sr-only">Image</div>
                        <div href="" class=" px-1 py-0.5 w-fit bg-mine-200 rounded-lg text-xs">
                            {{ $item->category->name }}
                        </div>
                    </div>
                    <div class="p-2 space-y-2">
                        <div class="text-sm font-semibold">{{ $item->name }} </div>
                        <div class="text-lg text-mine-400">IDR {{ number_format($item->price, 0, ',', '.') }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </flux:container>

    @livewire('newslatter')
</x-app-layout>
