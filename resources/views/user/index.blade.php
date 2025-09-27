<x-auth-layout title="Our Admins">
    <div class="flex justify-between">
        <div class=" lg:text-lg font-semibold">Our Admins</div>
        <x-a href="{{ route('admin.create') }}">Add Admin</x-a>
    </div>
    <x-session></x-session>
    <div class="overflow-x-auto">
        <div class="mt-4 w-full">
            <div class="flex gap-2 py-2 border-y border-black lg:gap-4 w-full items-center">
                <div class="w-12 text-center">#</div>
                <div class="w-1/3">Name</div>
                <div class="w-1/3">Email</div>
                <div class="w-1/3 text-center">Verified</div>
                <div class="w-24 text-center">Actions</div>
            </div>
            @foreach ($users as $key => $item)
                <div class="flex gap-2 py-2 last:border-b border-black lg:gap-4 w-full items-center">
                    <div class="w-12 text-center">{{ $key + 1 }} </div>
                    <div class="w-1/3">{{ $item->name }}</div>
                    <div class="w-1/3">{{ $item->email }}</div>
                    <div class="w-1/3 flex justify-center items-center">
                        @if ($item->email_verified_at ?? false)
                            <i class="bx bx-check text-3xl text-green-500"></i>
                        @else
                            <i class="bx bx-x text-3xl text-rose-500"></i>
                        @endif
                    </div>
                    <div class="w-24 text-center">
                        <form action="{{ route('admin.destroy', ['admin' => $item->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <x-button class="pb-0! border-b! hover:border-rose-400">
                                Delete</x-button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-auth-layout>
