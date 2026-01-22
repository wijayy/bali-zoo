<x-auth-layout :title="$title">
    <div class="flex justify-end">
        <flux:button variant="primary" as href="{{ route('suppliers.create') }}">Create Supplier</flux:button>
    </div>
    <div class="flex gap-4 py-2 text-black w-full dark:text-white">
        <div class="w-8 ">#</div>
        <div class="w-2/7">Supplier Name</div>
        <div class="w-1/7 text-center">Address</div>
        <div class="w-1/7 text-center">Contact Person</div>
        <div class="w-1/7 text-center">Email</div>
        <div class="w-1/7 text-center">Phone Number</div>
        <div class="w-1/7 text-center">Product Related</div>
        <div class="w-1/7 text-center">Action</div>
    </div>
    @foreach ($suppliers as $key => $item)
        <div class="flex items-center gap-4 py-2 text-black w-full dark:text-white">
            <div class="w-8 ">{{ $key + 1 }}</div>
            <div class="w-2/7 flex items-center gap-2">
                <div class="">{{ $item->name }}</div>
            </div>
            <div class="w-1/7 text-center">{{ $item->address }}</div>
            <div class="w-1/7 text-center">{{ $item->person }}</div>
            <div class="w-1/7 text-center">{{ $item->email }}</div>
            <a href="https://wa.me/{{ $item->phone }}" class="w-1/7 text-center">{{ $item->phone }}</a>
            <div class="w-1/7 text-center">{{ $item->product->count() }}</div>
            <div class="w-1/7 flex gap-2 justify-center">
                <flux:tooltip content="Edit Supplier">
                    <flux:button size="sm" as href="{{ route('suppliers.edit', $item->slug) }}"
                        icon="pencil-square"></flux:button>
                </flux:tooltip>
                <flux:tooltip content="Delete Supplier">
                    <flux:modal.trigger class="trigger" name="delete-{{ $key }}">
                        <flux:button size="sm" variant="danger" type="submit" icon="trash"></flux:button>
                    </flux:modal.trigger>
                </flux:tooltip>
                <flux:modal name="delete-{{ $key }}">
                    <form class="mt-4" action="{{ route('suppliers.destroy', $item->slug) }}" method="post">
                        @csrf
                        @method('delete')
                        <div class="">Delete {{ $item->name }}? Once removed, it`s gone for good.</div>
                        <div class="flex justify-end">
                            <flux:button variant="danger" type="submit">Delete</flux:button>
                        </div>
                    </form>
                </flux:modal>

            </div>
        </div>
    @endforeach
</x-auth-layout>
