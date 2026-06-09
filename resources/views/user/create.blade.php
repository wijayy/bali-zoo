<x-auth-layout title="Our Admins">
    <div class="flex justify-between">
        <div class=" lg:text-lg font-semibold">Add New Admin</div>
        {{-- <x-a href="{{ route('admin.create') }}">Add Admin</x-a> --}}
    </div>
    <x-session></x-session>

    <form action="{{ $user ?? false ? route('admin.update', ['admin' => $user->id]) : route('admin.store') }}"
        method="post" class="grid gap-4 mt-4 grid-cols-1 md:grid-cols-6 ">
        @csrf
        @if ($user ?? false)
            @method('put')
        @endif
        <div class="md:col-span-2">
            <x-label for="name" value="{{ __('name') }}" />
            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name ?? false)" required
                autofocus autocomplete="username" />
            <x-input-error :for="'name'"></x-input-error>
        </div>
        <div class="md:col-span-2">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email ?? false)" required
                autofocus autocomplete="username" />
            <x-input-error :for="'email'"></x-input-error>
        </div>
        <div class="md:col-span-2">
            <x-label for="is_superadmin" value="{{ __('Role') }}" />
            <x-form-select id="is_superadmin" class="block mt-1 w-full" type="text" name="is_superadmin"
                :value="old('is_superadmin', $user->is_superadmin ?? false)" required autofocus autocomplete="username">
                <x-form-option value="0">Admin</x-form-option>
                <x-form-option value="1">Super Admin</x-form-option>
            </x-form-select>
            <x-input-error :for="'is_superadmin'"></x-input-error>
        </div>
        <div class="md:col-span-3">
            <x-label for="password" value="{{ __('password') }}" />
            <x-input id="password" class="block mt-1 w-full" type="password" name="password" autofocus
                autocomplete="username" />
            <x-input-error :for="'password'"></x-input-error>
        </div>
        <div class="md:col-span-3">
            <x-label for="password_confirmation" value="{{ __('confirmation password') }}" />
            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
                autofocus autocomplete="username" />
            <x-input-error :for="'password_confirmation'"></x-input-error>
        </div>
        <x-button class="w-fit!">Submit</x-button>
    </form>
</x-auth-layout>
