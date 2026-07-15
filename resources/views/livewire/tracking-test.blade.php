<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <flux:heading size="xl">Test Tracking Resi</flux:heading>
        <flux:text>Periksa respons tracking langsung dari RajaOngkir.</flux:text>
    </div>

    <form wire:submit="track" class="grid grid-cols-1 md:grid-cols-3 gap-4 rounded-xl border border-zinc-200 p-5">
        <flux:select wire:model="courier" label="Ekspedisi">
            <option value="jne">JNE</option>
            <option value="jnt">J&amp;T Express</option>
            <option value="sicepat">SiCepat</option>
            <option value="anteraja">AnterAja</option>
            <option value="pos">POS Indonesia</option>
            <option value="ninja">Ninja Xpress</option>
        </flux:select>

        <flux:input wire:model="awb" label="Nomor Resi / AWB" placeholder="Contoh: CM40375640447" />

        <flux:input wire:model="lastPhoneNumber" label="5 digit terakhir telepon" inputmode="numeric"
            maxlength="5" placeholder="Khusus wajib untuk JNE" />

        <div class="md:col-span-3 flex justify-end">
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="track">Cek tracking</span>
                <span wire:loading wire:target="track">Memuat...</span>
            </flux:button>
        </div>
    </form>

    @if ($trackingError)
        <div class="rounded-lg bg-red-50 p-4 text-red-700">{{ $trackingError }}</div>
    @endif

    @if ($trackingData)
        @php
            $result = data_get($trackingData, 'rajaongkir.result', []);
            $summary = data_get($result, 'summary', []);
            $manifest = collect(data_get($result, 'manifest', []))->reverse()->values();
        @endphp

        <div class="rounded-xl border border-zinc-200 p-5 space-y-4">
            <flux:heading size="lg">Hasil RajaOngkir</flux:heading>

            @if ($summary)
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                    <div><span class="text-zinc-500">Status:</span> {{ data_get($summary, 'status', '-') }}</div>
                    <div><span class="text-zinc-500">Origin:</span> {{ data_get($summary, 'origin', '-') }}</div>
                    <div><span class="text-zinc-500">Destination:</span> {{ data_get($summary, 'destination', '-') }}</div>
                </div>
            @endif

            @forelse ($manifest as $entry)
                <div class="border-l-2 border-mine-400 pl-4 py-1">
                    <div class="text-xs text-zinc-500">{{ data_get($entry, 'manifest_date', '-') }}</div>
                    <div class="font-medium">{{ data_get($entry, 'manifest_description', '-') }}</div>
                    @if (data_get($entry, 'city_name'))
                        <div class="text-sm text-zinc-500">{{ data_get($entry, 'city_name') }}</div>
                    @endif
                </div>
            @empty
                <flux:text>RajaOngkir tidak mengembalikan riwayat perjalanan untuk resi ini.</flux:text>
            @endforelse
        </div>
    @endif
</div>
