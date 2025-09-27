<div class="absolute w-24 h-screen p-2 pr-0 border-e border-black md:p-4 md:w-64">
    <div class="flex flex-col items-center justify-between p-4 bg-white rounded-lg size-full">
        <div class="flex flex-col items-center w-full gap-4">
            <div class="w-full flex justify-center rounded-lg">
                <img class="size-12" src="{{ asset('assets/balizoo.jpg') }}" alt="">
                <div class=" font-semibold text-sm">Bali Zoo Merchandise</div>
            </div>
            <x-sidebar-link href="{{ route('dashboard') }}" :text="'Dashboard'" :active="request()->routeIs('dashboard')" class=""><i
                    class='text-lg bx bx-home-alt'></i></x-sidebar-link>
            <x-sidebar-link href="" :text="'Transaksi'" :active="request()->is('transaksi')" class="">
                <svg width="18px" height="18px" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M6.72827 19.7C7.54827 18.82 8.79828 18.89 9.51828 19.85L10.5283 21.2C11.3383 22.27 12.6483 22.27 13.4583 21.2L14.4683 19.85C15.1883 18.89 16.4383 18.82 17.2583 19.7C19.0383 21.6 20.4883 20.97 20.4883 18.31V7.04C20.4883 3.01 19.5483 2 15.7683 2H8.20828C4.42828 2 3.48828 3.01 3.48828 7.04V18.3C3.49828 20.97 4.95827 21.59 6.72827 19.7Z"
                            stroke="#292D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M9.25 10H14.75" stroke="#292D32" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
            </x-sidebar-link>
            <x-sidebar-link href="{{ route('products.index') }}" :text="'Products'" :active="request()->routeIs('products.*')" class="">
                <svg width="18px" height="18px" viewBox="0 0 48 48" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <rect width="48" height="48" fill="white" fill-opacity="0.01"></rect>
                        <path
                            d="M37 17V37M11 37V44H37V37M11 37H4V17C4 14 6 10.5 9 8C12 5.5 16 4 16 4H32C32 4 36 5.5 39 8C42 10.5 44 14 44 17V37H37M11 37V17"
                            stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M24 17V44" stroke="#000000" stroke-width="4" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M24 17L16 4" stroke="#000000" stroke-width="4" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M32 4L24 17" stroke="#000000" stroke-width="4" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
            </x-sidebar-link>
            <x-sidebar-link href="{{ route('admin.index') }}" :text="'Admin'" :active="request()->routeIs('admin.')" class="">
                <svg width="18px" height="18px" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <rect x="18" y="9" width="4" height="4" rx="2" transform="rotate(90 18 9)"
                            fill="#222222" stroke="#222222" stroke-width="2"></rect>
                        <rect x="18" y="17" width="4" height="4" rx="2" transform="rotate(90 18 17)"
                            fill="#222222" stroke="#222222" stroke-width="2"></rect>
                        <rect x="3" y="7" width="4" height="4" rx="2" transform="rotate(-90 3 7)"
                            fill="#222222" stroke="#222222" stroke-width="2"></rect>
                        <path d="M5 6V15C5 16.8856 5 17.8284 5.58579 18.4142C6.17157 19 7.11438 19 9 19H14"
                            stroke="#222222" stroke-width="2"></path>
                        <path d="M5 7V7C5 8.88562 5 9.82843 5.58579 10.4142C6.17157 11 7.11438 11 9 11H14"
                            stroke="#222222" stroke-width="2"></path>
                    </g>
                </svg></x-sidebar-link>
            <x-sidebar-link href="{{ route('analytics') }}" :text="'Analitik'" :active="request()->routeIs('analitik')" class="stroke-2">
                <svg fill="#000000" width="18px" height="18px" viewBox="-0.2 0 32.939 32.939"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="2"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g transform="translate(-225.15 -385.057)">
                            <path d="M256.689,418H225.15V386.057a1,1,0,0,1,2,0V416h29.539a1,1,0,0,1,0,2Z"></path>
                            <path
                                d="M230.171,409.995a1,1,0,0,1-.68-1.733l5.024-4.669a4.725,4.725,0,0,1,6.441.023l1.152,1.087a3.628,3.628,0,0,0,5.4-.468l7.4-9.912a1,1,0,0,1,1.6,1.2l-7.4,9.912a5.628,5.628,0,0,1-8.373.726l-1.152-1.087a2.717,2.717,0,0,0-3.706-.014l-5.025,4.67A1,1,0,0,1,230.171,409.995Z">
                            </path>
                        </g>
                    </g>
                </svg></x-sidebar-link>
        </div>
        <div class="flex flex-col w-full gap-4">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <x-sidebar-link href="{{ route('dashboard') }}"
                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                    :text="'Logout'" :active="request()->routeIs('')" class="">
                    <i class='text-lg bx bx-log-out'></i>
                </x-sidebar-link>
            </form>
            <a href="{{ route('profile.show') }}" class="flex items-center gap-1">
                <div class="h-10 aspect-square">
                    <img src="{{ Auth::user()->profile_photo_url }}" class="rounded-full size-full" alt="">
                </div>
                <div class="hidden md:block">
                    <div class="">{{ Auth::user()->name }}</div>
                    <div class="">{{ Auth::user()->role?->nama }}</div>
                </div>
            </a>
        </div>
    </div>
</div>
