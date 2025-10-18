<x-app-layout title="Shop" header="{{ false }}">
    <div class="">
        {{-- <x-secondary-header :image="asset('assets/jerry-wang-qBrF1yu5Wys-unsplash.jpg')" text="Shop"></x-secondary-header> --}}
        <div class="pt-20">
            <div class="text-center font-semibold text-lg">Our Products</div>
            <div class="text-sm text-center">Wildlife-Inspired Merchandise You’ll Love.</div>
        </div>
    </div>
    <flux:container class="flex justify-center ">
        <div class="w-full md:w-3/5 ">
            <flux:input wire:model.live='search' placeholder="Search a product here"></flux:input>
        </div>
    </flux:container>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-2 lg:gap-4 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="">
            <div class="text-center font-semibold text-lg">Filters</div>


                @foreach ($categories as $item)
                <label for="category" class="flex gap-2 items-center cursor-pointer">
                    <input type="radio" name="category" value="{{ $item->slug }}">
                    <div class="">{{ $item->name }}</div>
                </label>
                @endforeach



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
                            <div class="flex gap-0.5 items-center">
                                <div class="sr-only">rating</div>
                                @for ($i = 0; $i < floor($item->average_rate); $i++)
                                    <i class="bx bxs-star text-yellow-500"></i>
                                @endfor
                                @if (fmod($item->average_rate, 1) != 0)
                                    <i class="bx bxs-star-half text-yellow-500"></i>
                                @endif
                                @for ($i = 5; $i > ceil($item->average_rate); $i--)
                                    <i class="bx bx-star text-stone-500"></i>
                                @endfor
                                <div class="pl-2 font-inter">
                                    {{ $item->average_rate }}
                                </div>
                            </div>
                            <div class="text-lg text-mine-400">IDR {{ number_format($item->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </div>
    <div class="">{{ $products->links() }} </div>

    @livewire('follow-instagram')
    @livewire('newslatter')
</x-app-layout>
