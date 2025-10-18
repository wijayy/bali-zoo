<x-app-layout title="Home" header="true">
    <div class="w-full h-screen bg-center bg-cover bg-no-repeat"
        style="background-image: url({{ asset('assets/mohit-suthar-J5dg1V2FHD4-unsplash.jpg') }})">
        <div class="px-4 mx-auto h-full max-w-7xl sm:px-6 lg:px-8 flex p-4 md:p-8 items-end md:items-center justify-end">
            <div class="aspect-3/2 w-8/12 sm:w-1/2 md:w-1/3 space-y-2 bg-white rounded-lg p-4">
                <div class="text-xs font-bold">New Arrival</div>
                <div class="text-xl md:text-3xl text-mine-400">Discover Our New Collection</div>
                <div class="text-xs md:text-sm">Bring the magic of the zoo into your life with our exclusive merchandise
                    collection. Every purchase supports wildlife conservation!</div>
                <x-a>Buy Now</x-a>
            </div>
        </div>
    </div>

    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="text-center font-semibold text-lg">Browse the Range</div>
        <div class="text-sm text-center">Discover a unique selection designed especially for wildlife lovers!</div>

        <!-- Swiper -->
        <div class="swiper mySwiper mt-4">
            <div class="swiper-wrapper">
                @foreach ($categories as $item)
                    <a href="{{ route('shop.index', ['category' => $item->slug]) }}" class="swiper-slide">
                        <div class="aspect-3/4 rounded-lg bg-center bg-no-repeat bg-cover"
                            style="background-image: url({{ asset("storage/$item->image") }})">
                        </div>
                        <div class="text-center">{{ $item->name }} </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="text-center font-semibold text-lg">Our Recomendation</div>
            <div class="text-sm text-center w-4/5 mx-auto">Step into the world of Bali Zoo through our handpicked recommendations —
                featuring merchandise inspired by the animals you love and the moments you cherish. From sustainable
                lifestyle products to adorable keepsakes, each item tells a story of nature, conservation, and the joy
                of connecting with wildlife</div>

            <form action="{{ route('shop.index') }}" method="GET" class="w-full mt-4 justify-center flex ">
                <x-input name="search" class="w-full sm:w-3/4 md:w-1/4" class="self-center"
                    placeholder="Search a product here"></x-input>
                <button class="border-b-2 px-2 cursor-pointer" type="submit"><i class="bx bx-search-alt"></i></button>
            </form>

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

    @livewire('follow-instagram')
    @livewire('newslatter')



    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 2,
            spaceBetween: 16,
            loop: true,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
            },
        });
    </script>

</x-app-layout>
