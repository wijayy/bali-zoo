<div class="">

    <flux:modal name="tambah-alamat" class="">
        <form wire:submit='save' class="space-y-4">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold">{{ $title }}</h2>
                    <p class="text-sm text-slate-500">Masukkan data alamat disini.</p>
                </div>
                <flux:button variant="ghost" icon="x-mark" wire:click='tutupModal' size="sm" alt="Tutup modal">
                </flux:button>
            </div>

            <div class="">
                <flux:input wire:model.live='nama' label="Nama" required></flux:input>
            </div>
            <div class="">
                <flux:input wire:model.live='phone' label="Phone" required></flux:input>
            </div>
            <div class="">
                <flux:textarea wire:model.live='alamat' label="Alamat" required></flux:textarea>
            </div>
            <div class="">
                <flux:select wire:model.live='province_id' label="Provinsi" required>
                    <flux:select.option value="{{ null }}">Pilih Provinsi</flux:select.option>
                    @foreach ($provinces as $item)
                        <flux:select.option value="{{ $item['id'] }}">{{ $item['name'] }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="">
                <flux:select wire:model.live='regency_id' label="Kabupaten/Kota" required>
                    <flux:select.option value="{{ null }}">Pilih Kabupaten/Kota</flux:select.option>
                    @foreach ($regencies as $item)
                        <flux:select.option value="{{ $item['id'] }}">{{ $item['name'] }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="">
                <flux:select wire:model.live='district_id' label="Kecamatan" required>
                    <flux:select.option value="{{ null }}">Pilih Kecamatan</flux:select.option>
                    @foreach ($districts as $item)
                        <flux:select.option value="{{ $item['id'] }}">{{ $item['name'] }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="">
                <flux:select wire:model.live='village_id' label="Desa/Kelurahan" required>
                    <flux:select.option value="{{ null }}">Pilih Desa/Kelurahan</flux:select.option>
                    @foreach ($villages as $item)
                        <flux:select.option value="{{ $item['id'] }}">{{ $item['name'] }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="">
                <flux:input wire:model.live='postal_code' label="Kode pos" readonly></flux:input>
            </div>
            <div class="flex items-center gap-2">
                <input id="default-address" type="checkbox" wire:model.live="default"
                    class="h-4 w-4 rounded border-slate-300 text-slate-600 focus:ring-slate-500">
                <label for="default-address" class="text-sm text-slate-600">Jadikan alamat utama</label>
            </div>

            <div class="flex justify-center gap-4">
                <flux:button type="button" variant="primary" wire:click='tutupModal'>Batal</flux:button>
                <flux:button type="submit" variant="underline">Submit</flux:button>
                <flux:button type="button" variant="danger" wire:click='openDeleteModal'>Delete</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="hapus-alamat" class="">
        <div class="">Apakah yakin akan menghapus alamat?</div>
        <div class="mt-4 flex justify-end">
            <flux:button variant="underline" wire:submit="tutupModal">Batal</flux:button>
            <flux:button variant="danger" wire:click='deleteAlamat({{ $id }})'>Submit</flux:button>
        </div>

    </flux:modal>

</div>
