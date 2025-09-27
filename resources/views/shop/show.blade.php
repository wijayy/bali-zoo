<x-app-layout title="{{ $product->name }}">
    <div class="pt-16">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

        </div>
    </div>
    <div class="">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 flex flex-wrap-reverse relative sm:flex-nowrap gap-4">
            <div class="flex w-full aspect-square lg:w-1/3 sm:w-1/2 h-fit gap-4 sticky"
                x-data="{ image: '{{ asset('storage/' . $product->image1) }}' }">
                <div class="sr-only">image</div>
                <div class="w-1/5 flex justify-between flex-col gap-4">
                    @for ($i = 1; $i < 6; $i++) @if ($product['image' . $i] ?? false) <div
                        class="bg-center cursor-pointer bg-no-repeat bg-cover aspect-square"
                        x-on:click="image = '{{ asset('storage/' . $product['image' . $i]) }}'"
                        style="background-image: url({{ asset('storage/' . $product['image' . $i]) }})">
                </div>
                @endif
                @endfor
            </div>
            <div class="bg-center bg-no-repeat bg-cover aspect-square  w-4/5"
                :style="'background-image: url(' + image + ')'">
            </div>
        </div>
        <div class="w-full sm:w-1/2 lg:w-2/3">
            <div class="sr-only">Description</div>
            <div class="text-xl lg:text-4xl">{{ $product->name }} </div>
            <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}"
                class="text-sm mt-1 lg:text-lg border-b-2">{{ $product->category->name }} </a>
            <div class="flex mt-2 gap-0.5 items-center">
                <div class="sr-only">rating</div>
                @for ($i = 0; $i < floor($product->average_rate); $i++)
                    <i class="bx bxs-star text-yellow-500"></i>
                    @endfor
                    @if (fmod($product->average_rate, 1) != 0)
                    <i class="bx bxs-star-half text-yellow-500"></i>
                    @endif
                    @for ($i = 5; $i > ceil($product->average_rate); $i--)
                    <i class="bx bx-star text-stone-500"></i>
                    @endfor
                    <div class="pl-2 font-inter">
                        {{ $product->average_rate }}
                    </div>
                    <div class=""></div>
            </div>
            <div class="text-gray-400 text-lg lg:text-2xl mt-4">IDR.
                {{ number_format($product->price, 0, ',', '.') }} </div>
            <form action="{{ route('cart.store') }}" method="post" class="mt-8 flex gap-4 text-sm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <x-input name="qty" type="number" value="1" class="w-12" min="1" max="{{ $product->stock }}"></x-input>
                <button type="submit" class="px-4 cursor-pointer  border-b-2">Add to cart</button>
            </form>
        </div>
    </div>
    </div>
    <div class="">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8" x-data="{ review: false }">
            <div class="flex gap-4 justify-center">
                <div :class="review ? 'border-black' : 'border-mine-400'" class="border-b-2 px-2 cursor-pointer"
                    @click="review = false">Description
                </div>
                <div :class="!review ? 'border-black' : 'border-mine-400'" class="border-b-2 px-2 cursor-pointer"
                    @click="review= true">Review
                    ({{ $product->review->count() }}) </div>
            </div>
            <div class="mt-4" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90" x-show="!review">
                {!! $product->description !!}
            </div>
            <div class="mt-4" x-cloak="" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90" x-show="review" x-data="{
                    limit: 5
                }">
                @foreach ($product->review as $index => $item)
                <div class="border-b border-gray-400 py-2 px-4 last:border-b-0"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                    x-show="{{ $index }} < limit">
                    <div class="text-gray-400 text-xs lg:text-xs">{{ $product->created_at->diffForHumans() }}
                    </div>
                    @if ($item->image ?? false)
                    <div class="size-24 mt-1 bg-center bg-no-repeat bg-cover"
                        style="background-image: url({{ asset('storage/' . $item->image) }})"></div>
                    @endif
                    <div class="flex mt-2 gap-0.5 items-center">
                        <div class="sr-only">rating</div>
                        @for ($i = 0; $i < floor($item->rate); $i++)
                            <i class="bx bxs-star text-yellow-500"></i>
                            @endfor
                            @for ($i = 5; $i > ceil($item->rate); $i--)
                            <i class="bx bx-star text-stone-500"></i>
                            @endfor
                    </div>
                    <div class="text-xs lg:text-sm">{{ $item->user->name }} </div>
                    <div class="">{{ $item->review }} </div>
                </div>
                @endforeach
                <div class="flex justify-center">
                    <button x-show="limit < {{ count($product->review) }}" @click="limit += 5"
                        class="mt-4 px-4 py-2 border-b-2 self-center cursor-pointer">
                        More
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
