<div class="mx-auto grid max-w-7xl grid-cols-1 items-start gap-8 px-4 sm:px-6 md:grid-cols-5 lg:px-8">
    <aside class="w-full rounded-xl  p-2  md:sticky md:top-20">
        <flux:navlist variant="outline">
            <flux:navlist.item :href="route('settings.profile')" :current="request()->routeIs('settings.profile')"
                wire:navigate>{{ __('Profile') }}</flux:navlist.item>
            {{-- <flux:navlist.item :href="route('settings.bussiness-info')" wire:navigate>{{ __('Bussiness Info') }}</flux:navlist.item> --}}
            <flux:navlist.item :href="route('address.index')" :current="request()->routeIs('address.index')"
                wire:navigate>{{ __('My Address') }}</flux:navlist.item>
            <flux:navlist.item :href="route('settings.password')" :current="request()->routeIs('settings.password')"
                wire:navigate>{{ __('Password') }}</flux:navlist.item>
            <flux:navlist.item :href="route('settings.appearance')" :current="request()->routeIs('settings.appearance')"
                wire:navigate>{{ __('Appearance') }}</flux:navlist.item>
        </flux:navlist>
    </aside>

    <div class="md:hidden">
        <flux:separator />

    </div>

    <div class="min-w-0 md:col-span-4 self-stretch">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full">
            {{ $slot }}
        </div>
    </div>
</div>
