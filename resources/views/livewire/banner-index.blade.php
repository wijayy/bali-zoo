<div>
    <x-slot name="title">
        Banner
    </x-slot>

    <flux:container-sidebar title="Banner">
        <div class="flex justify-end">
            <flux:button variant="primary" as href="{{ route('banners.create') }}">Create Banner</flux:button>
        </div>

        <div class="grid gap-4 mt-4">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                <x-input wire:model.debounce.500ms="search" placeholder="Search banner..." />
                <x-form-select wire:model="status" class="min-w-[180px]">
                    <x-form-option value="">All Status</x-form-option>
                    <x-form-option value="active">Active</x-form-option>
                    <x-form-option value="inactive">Inactive</x-form-option>
                </x-form-select>
                <div class="flex items-end">
                    <flux:button variant="primary" wire:click="$set('search', '')">Reset</flux:button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="min-w-3xl">
                    <div class="flex gap-2 py-2 lg:gap-4 w-full text-black dark:text-white items-center font-semibold">
                        <div class="w-10 text-center">#</div>
                        <div class="w-1/4">Banner</div>
                        <div class="w-1/4 text-center">Schedule</div>
                        <div class="w-1/6 text-center">Status</div>
                        <div class="w-1/5 text-center">Action</div>
                    </div>
                    @forelse ($banners as $key => $item)
                        <div
                            class="flex gap-2 py-2 lg:gap-4 items-center border-b border-black text-black dark:text-white">
                            <div class="w-10 text-center">
                                {{ ($banners->currentPage() - 1) * $banners->perPage() + $key + 1 }}</div>
                            <div class="w-1/4 flex gap-3 items-center">
                                <img class="w-20 h-12 object-cover rounded" src="{{ asset('storage/' . $item->image) }}"
                                    alt="{{ $item->name }}">
                                <div>
                                    <div class="font-medium">{{ $item->name }}</div>
                                </div>
                            </div>
                            <div class="w-1/4 text-center">
                                <div>{{ optional($item->startShow)->format('d M Y H:i') }}</div>
                                <div class="text-sm text-slate-500">{{ optional($item->endShow)->format('d M Y H:i') }}
                                </div>
                            </div>
                            <div class="w-1/6 text-center">
                                @if ($item->isActive())
                                    <span class="text-emerald-600 font-semibold">Active</span>
                                @else
                                    <span class="text-rose-600 font-semibold">Inactive</span>
                                @endif
                            </div>
                            <div class="w-1/5 flex gap-2 justify-center">
                                <flux:button icon="pencil-square" size="sm" variant="primary" color="emerald" as
                                    href="{{ route('banners.edit', ['slug' => $item->slug]) }}"></flux:button>
                                <flux:modal.trigger name="delete-{{ $item->id }}">
                                    <flux:button icon="trash" size="sm" variant="primary" color="rose">
                                    </flux:button>
                                </flux:modal.trigger>
                                <flux:modal name="delete-{{ $item->id }}">
                                    <div class="mt-4">Delete banner {{ $item->name }}? Once removed, it`s gone for
                                        good.</div>
                                    <div class="flex justify-end mt-4">
                                        <flux:button variant="danger" wire:click="delete({{ $item->id }})">Delete
                                        </flux:button>
                                    </div>
                                </flux:modal>
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-center text-slate-500">No banners found.</div>
                    @endforelse

                </div>
            </div>

            <div class="mt-4">
                {{ $banners->links() }}
            </div>
        </div>
    </flux:container-sidebar>
</div>
