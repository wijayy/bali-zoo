<nav x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 50)"
    :class="scrolled ? 'bg-white text-black shadow-md' : 'text-white bg-transparent'" class="fixed z-50 w-full ">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between w-full p-4 h-14">
            <div class="flex items-center gap-1">
                <div class="sr-only">Application logo</div>
                <x-application-logo class="w-8"></x-application-logo>
                <div class="text-xs md:text-sm font-semibold">
                    <div class="">Bali Zoo</div>
                    <div class="">Merchandise</div>
                </div>
            </div>
            <div class="space-x-4 hidden md:flex">
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-nav-link>
                <x-nav-link href="{{ route('shop.index') }}" :active="request()->is('shop')">Shop</x-nav-link>
                <x-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">About</x-nav-link>
                <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">Contact</x-nav-link>
                <x-nav-link href="{{ route('transaction.index') }}" :active="request()->is('transaction')">Transaction
                </x-nav-link>
            </div>
            <div class="flex items-center gap-4">
                @auth
                <x-nav-icon :label="'profile'" href="{{ route('profile.show') }}">
                    <i class='text-xl bx text-inherit bxs-user-detail'></i>
                </x-nav-icon>
                @endauth
                <x-nav-icon :label="'cart'" href="{{ route('cart.index') }}">
                    {{-- <i class='text-xl bx text-inherit bx-cart-alt'></i> --}}
                    {{-- @auth --}}
                    <div class="absolute bg-red-500 top-0 left-0 p-1 rounded-full">2asdfasdfasd</div>
                    {{-- @endauth --}}
                </x-nav-icon>
                @guest
                <x-nav-icon :label="'login'" href="{{ route('login') }}">
                    <i class='text-xl bx text-inherit bx-log-in'></i>
                </x-nav-icon>
                @endguest
                @auth
                <form action="{{ route('logout') }}" method="post">
                    <x-nav-icon :label="'logout'" href="" @click.prevent="$el.closest('form').submit()">
                        <i class='text-xl bx text-inherit bx-log-out'></i>
                    </x-nav-icon>
                </form>
                @endauth
                <div class="block md:hidden" href="" @click="open = !open">
                    <i class='text-xl bx text-inherit bx-menu'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden w-full bg-white absolute top-full">
        <div class="pt-2 pb-3 px-4 space-y-2">
            <x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('shop.index') }}" :active="request()->is('shop')">Shop
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">About
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">Contact
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('transaction.index') }}" :active="request()->is('transaction')">
                Transaction</x-responsive-nav-link>
        </div>
    </div>
</nav>
