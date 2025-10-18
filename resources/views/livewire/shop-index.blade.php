<div>
    <div class="">
        {{-- <x-secondary-header :image="asset('assets/jerry-wang-qBrF1yu5Wys-unsplash.jpg')" text="Shop"></x-secondary-header> --}}
        <div class="pt-20">
            <div class="text-center font-semibold text-lg">Our Products</div>
            <div class="text-sm text-center">Wildlife-Inspired Merchandise You’ll Love.</div>
        </div>
    </div>
    <flux:container class="flex justify-center mt-4">
        <div class="w-full md:w-3/5 ">
            <flux:input wire:model.live='search' placeholder="Search a product here"></flux:input>
        </div>
    </flux:container>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-2 lg:gap-4 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="">
            <div class="text-center font-semibold text-lg">Filters</div>

            <flux:radio.group wire:model.live='category' label="By Category">
                @foreach ($categories as $item)
                <flux:radio value="{{ $item->slug }}" label="{{ $item->name }}"></flux:radio>
                @endforeach
            </flux:radio.group>
            <div class="mt-4"></div>
            <flux:label>By Price</flux:label>
            <div class="flex gap-4 mt-4">
                <flux:input type="number" wire:model.live='min' placeholder="Min Price"></flux:input>
                <flux:input type="number" wire:model.live='max' placeholder="Max Price"></flux:input>
            </div>
        </div>
        <div class=" md:col-span-4">
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

        </div>
    </div>
    <div class="mt-4">{{ $products->links() }} </div>

    @livewire('follow-instagram')
    @livewire('newslatter')
</div>
