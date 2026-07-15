<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('My Address')" :subheading="__('View and manage your saved addresses for quick checkout and delivery.')">
        <div class="flex justify-end">
            <flux:button variant="primary" icon="plus" wire:click="tambahAlamat">Tambah Alamat</flux:button>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4">
            @foreach ($this->address as $address)
                <div wire:click='editAlamat({{ $address->id }})'
                    class="cursor-pointer border rounded-lg bg-white p-4 {{ $address->default ? 'ring-2 ring-mine-400' : 'ring-mine-300 ring-2' }}">
                    <p>{{ $address->nama }}</p>
                    <p>{{ $address->phone }}</p>
                    <p>{{ $address->alamat }}</p>
                    <p>{{ $address->village }}, {{ $address->district }}
                        {{ $address->regency }}
                        {{ $address->province }}</p>

                    @if ($address->default)
                        <div class="text-mine-400 text-sm font-semibold">Alamat Default</div>
                    @endif
                </div>
            @endforeach
        </div>
    </x-settings.layout>

    @livewire('address-create')
</section>
