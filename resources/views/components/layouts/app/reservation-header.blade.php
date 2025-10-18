<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen static bg-white dark:bg-zinc-800 font-poppins">
    <flux:header container
        class="border-b border-zinc-200 bg-zinc-50 absolute top-0 left-0 right-0 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <a href="{{ route('b2b-home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0"
            wire:navigate>
            <x-app-logo />
        </a>

        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:navbar.item icon="Home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                {{ __('Home') }}
            </flux:navbar.item>
            @auth
                <flux:navbar.item icon="clock" :href="route('reservation.history')" :current="request()->routeIs('reservation.history')"
                    wire:navigate>
                    {{ __('Reservation History') }}
                </flux:navbar.item>
            @endauth
        </flux:navbar>

        <flux:spacer />
        @guest
            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="arrow-right-end-on-rectangle" :href="route('login')"
                    :current="request()->routeIs('login')" wire:navigate>
                    {{ __('Login') }}
                </flux:navbar.item>
            </flux:navbar>
        @endguest
        @auth
            <!-- Desktop User Menu -->
            <flux:dropdown position="top" align="end">
                <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->role }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @endauth
    </flux:header>

    <!-- Mobile Menu -->
    <flux:sidebar stashable sticky
        class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')">
                <flux:navlist.item icon="home" :href="route('home')"
                    :current="request()->routeIs('home')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navlist.item>
                            @auth
                <flux:navlist.item icon="clock" :href="route('reservation.history')" :current="request()->routeIs('reservation.history')"
                    wire:navigate>
                    {{ __('Reservation History') }}
                </flux:navlist.item>
            @endauth
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />
    </flux:sidebar>

    {{ $slot }}

    @livewire('footer')
    @livewire('copyright')

    @fluxScripts
</body>

</html>
