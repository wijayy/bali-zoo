<x-auth-layout :title="$title">
    <div class="flex justify-end">
        <flux:button variant="primary" as href="{{ route('categories.create') }}">Create Category</flux:button>
    </div>
    <div class="flex gap-4 py-2">
        <div class="w-8 ">#</div>
        <div class="w-3/5">Category Name</div>
        <div class="w-1/5 text-center">Products Related</div>
        <div class="w-1/5 text-center">Action</div>
    </div>
    @foreach ($categories as $key => $item)
        <div class="flex items-center gap-4 py-2">
            <div class="w-8 ">{{ $key+1 }}</div>
            <div class="w-3/5 flex items-center gap-2">
            <img class="w-12" src="{{ asset("storage/{$item->image}") }}" alt="">
            <div class="">{{ $item->name }}</div>
            </div>
            <div class="w-1/5 text-center">{{ $item->product->count() }}</div>
            <div class="w-1/5 flex gap-2 justify-center">
                <flux:tooltip content="Edit Category">
                    <flux:button size="sm" as href="{{ route('categories.edit', $item->slug) }}" icon="pencil-square"></flux:button>
                </flux:tooltip>
                <flux:tooltip content="Delete Category">
                    <flux:modal.trigger class="trigger" name="delete-{{ $key }}">
                        <flux:button size="sm" variant="danger" type="submit" icon="trash"></flux:button>
                    </flux:modal.trigger>
                </flux:tooltip>
                <flux:modal name="delete-{{ $key }}">
                    <form class="mt-4" action="{{ route('categories.destroy', $item->slug) }}" method="post">
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
