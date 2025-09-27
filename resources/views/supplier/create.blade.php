@php
    $title = $supplier ?? false ? "Edit Supplier $supplier->name" : 'Add Supplier';
@endphp

<x-auth-layout title="{{ $title }}">
    <form enctype="multipart/form-data"
        action="{{ $supplier ?? false ? route('suppliers.update', ['supplier' => $supplier->slug]) : route('suppliers.store') }}"
        method="post">
        @csrf
        @if ($supplier ?? false)
            @method('put')
        @endif

        <div class="mt-4">
            <x-label required="true" for="name" value="{{ __('supplier Name') }}" />
            <x-input value="{{ old('name', $supplier->name ?? false) }}" id="name" type="text"
                class="mt-1 block w-full" name="name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <div class="mt-4">
            <flux:button type="submit">Submit</flux:button>
        </div>
    </form>
</x-auth-layout>
