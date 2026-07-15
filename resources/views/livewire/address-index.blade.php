<div>
    <flux:container>

        <div class="h-20"></div>

        <flux:text position="center" size="xl">My Addresses</flux:text>
        <flux:text position="center">View and manage your saved addresses for quick checkout and delivery.
        </flux:text>

        <div class="">
            <flux:button variant="primary" icon="plus" wire:click="tambahAlamat">Tambah Alamat</flux:button>
        </div>

        <div class="grid grid-cols-1 mt-4 gap-4">
            @foreach ($this->address as $address)
                <div wire:click='editAlamat({{ $address->id }})'
                    class="border rounded-lg bg-white p-4 {{ $address->default ? 'ring-2 ring-mine-400' : 'ring-mine-300 ring-2' }}">
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
    </flux:container>

    @livewire('address-create')
</div>
