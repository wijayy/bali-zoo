<div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
    @if ($banners->isNotEmpty())
        <div class="swiper bannerShowSwiper overflow-hidden rounded-lg">
            <div class="swiper-wrapper">
                @foreach ($banners as $banner)
                    <div class="swiper-slide">
                        <div class="relative min-h-56 overflow-hidden rounded-lg bg-mine-200 aspect-3/1">
                            <img class="absolute inset-0 h-full w-full object-cover"
                                src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->name }}">
                            <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-black/20 to-transparent">
                            </div>
                            <div class="">asdfasdf</div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($banners->count() > 1)
                <div class="swiper-pagination banner-show-pagination"></div>
                <button type="button"
                    class="banner-show-prev absolute left-3 top-1/2 z-10 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-full bg-white/85 text-mine-400 shadow hover:bg-white"
                    aria-label="Previous banner">
                    <i class="bx bx-chevron-left text-2xl"></i>
                </button>
                <button type="button"
                    class="banner-show-next absolute right-3 top-1/2 z-10 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-full bg-white/85 text-mine-400 shadow hover:bg-white"
                    aria-label="Next banner">
                    <i class="bx bx-chevron-right text-2xl"></i>
                </button>
            @endif
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (!window.Swiper || document.querySelector('.bannerShowSwiper')?.swiper) {
                    return;
                }

                new Swiper('.bannerShowSwiper', {
                    loop: {{ $banners->count() > 1 ? 'true' : 'false' }},
                    slidesPerView: 1,
                    spaceBetween: 16,
                    autoplay: {
                        delay: 4500,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.banner-show-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.banner-show-next',
                        prevEl: '.banner-show-prev',
                    },
                });
            });
        </script>
    @endif
</div>
