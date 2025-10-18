<x-form-section submit="submit">
    <x-slot name="title">
        {{ __('Address') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Manage your address details for delivery and account settings.') }}
    </x-slot>
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="alamat">Alamat Lengkap</x-label>
            <x-input type="text" wire:model.live="state.address" id="alamat" class="mt-1 w-full " />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <label for="province_id">Provinsi</label>
            <x-form-select wire:model.live="state.province_id" id="province_id" class="w-full ">
                <x-form-option value="">-- Pilih Provinsi --</x-form-option>
                @foreach ($provinces as $provinsi)
                    <x-form-option value="{{ $provinsi->id }}">{{ $provinsi->name }}</x-form-option>
                @endforeach
            </x-form-select>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <label for="regency_id">Kabupaten/Kota</label>
            <x-form-select wire:model.live="state.regency_id" id="regency_id" class="w-full ">
                <x-form-option value="">-- Pilih Kabupaten/Kota --</x-form-option>
                @foreach ($regencies as $kab)
                    <x-form-option value="{{ $kab->id }}">{{ $kab->name }}</x-form-option>
                @endforeach
            </x-form-select>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <label for="district_id">Kecamatan</label>
            <x-form-select wire:model.live="state.district_id" id="district_id" class="w-full ">
                <x-form-option value="">-- Pilih Kecamatan --</x-form-option>
                @foreach ($districts as $kec)
                    <x-form-option value="{{ $kec->id }}">{{ $kec->name }}</x-form-option>
                @endforeach
            </x-form-select>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <label for="village_id">Kelurahan/Desa</label>
            <x-form-select wire:model.live="state.village_id" id="village_id" class="w-full ">
                <x-form-option value="">-- Pilih Kelurahan/Desa --</x-form-option>
                @foreach ($villages as $desa)
                    <x-form-option value="{{ $desa->id }}">{{ $desa->name }}</x-form-option>
                @endforeach
            </x-form-select>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
