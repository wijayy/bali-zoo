<x-auth-layout title="Our Admins">
    <div class="flex justify-between">
        <div class=" lg:text-lg font-semibold">Add New Admin</div>
        {{-- <x-a href="{{ route('admin.create') }}">Add Admin</x-a> --}}
    </div>
    <x-session></x-session>

    <form action="{{ route('admin.store') }}" method="post" class="grid gap-4 mt-4 grid-cols-1 md:grid-cols-2 ">
        @csrf
        <div>
            <x-label for="name" value="{{ __('name') }}" />
            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="username" />
            <x-input-error :for="'name'"></x-input-error>
        </div>
        <div>
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :for="'email'"></x-input-error>
        </div>
        <div>
            <x-label for="password" value="{{ __('password') }}" />
            <x-input id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')" required
                autofocus autocomplete="username" />
            <x-input-error :for="'password'"></x-input-error>
        </div>
        <div>
            <x-label for="password_confirmation" value="{{ __('confirmation password') }}" />
            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" :value="old('password_confirmation')" required
                autofocus autocomplete="username" />
            <x-input-error :for="'password_confirmation'"></x-input-error>
        </div>
        <x-button class="w-fit!">Submit</x-button>
    </form>
</x-auth-layout>
