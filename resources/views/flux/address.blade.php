@props(['active' => false, 'address'])

<div class="border rounded-lg bg-white p-4 {{ $active ? 'ring-2 ring-mine-400' : 'ring-mine-300 ring-2' }}">
    <p>{{ $address->nama }}</p>
    <p>{{ $address->phone }}</p>
    <p>{{ $address->alamat }}</p>
    <p>{{ $address->village->name }}, {{ $address->village->district->name }}
        {{ $address->village->district->regency->name }} {{ $address->village->district->regency->province->name }}</p>

    @if ($address->default)
        <div class="text-mine-400 text-sm font-semibold">Alamat Default</div>
    @endif
</div>
