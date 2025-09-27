<x-app-layout title="Shop" header="true">
    <div class="">
        <x-secondary-header :image="asset('assets/jerry-wang-qBrF1yu5Wys-unsplash.jpg')" text="Shop"></x-secondary-header>
        <form class="" action="" method="GET" x-data="{ filter: false }">
            <div class="bg-mine-200">
                <div class="w-full px-4 mx-auto max-w-7xl h-16 sm:px-6 lg:px-8 flex gap-4 items-center">
                    <div class="cursor-pointer space-x-2 text-nowrap" @click="filter = !filter"><i
                            class='bx pr-2 bx-slider'></i>Filters
                    </div>
                    <button type="reset" class="cursor-pointer text-nowrap space-x-2"><i
                            class='bx pr-2 bx-reset'></i>Reset
                    </button>
                    <div class=" w-full flex items-center justify-between">
                        <p class="text-center border-l-2 pl-4">
                            Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }}
                            results
                        </p>
                        <div class="flex gap-4">
                            <div class="">
                                <label for="paginate">Show</label>
                                <x-input min="5" class="w-10 text-center" type="number" name="paginate"
                                    value="{{ request('paginate', 24) }}" id="paginate" />
                            </div>
                            <div class="">
                                <label for="sort">Sort by</label>
                                <select class="border-b-2" name="sort" id="sort">
                                    <option @if (request('sort') == 'popular') selected @endif value="popular">Popular
                                    </option>
                                    <option @if (request('sort') == 'newest') selected @endif value="newest">Newest
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class=" px-4 mx-auto max-w-7xl sm:px-6 lg:px-8" x-show="filter"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <x-label>Category</x-label>
                <select class="border-b-2" name="sort" id="sort">
                    <option @if (request('sort') == 'popular') selected @endif value="popular">Popular
                    </option>
                    <option @if (request('sort') == 'newest') selected @endif value="newest">Newest
                    </option>
                </select>

            </div>
            <div action="" method="GET" class="w-full mt-4 justify-center flex ">
                <x-input name="search" value="{{ request('search') ?? '' }}" class="w-full sm:w-1/2 md:w-1/3"
                    placeholder="Search a product here"></x-input>
                <button class="border-b-2 px-2 cursor-pointer" type="submit"><i class="bx bx-search-alt"></i></button>
            </div>
        </form>
    </div>
    <div class="">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
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
</x-app-layout>
