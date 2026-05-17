<div>
    <x-slot name="title">
        {{ $banner ? 'Edit Banner' : 'Create Banner' }}
    </x-slot>

    <flux:container-sidebar title="{{ $banner ? 'Edit Banner' : 'Create Banner' }}">
        <form wire:submit="save" class="space-y-6">
            <div class="">
                <flux:input type="file" wire:model="image" accept="image/*" label="Banner Image"></flux:input>
            </div>
            <div>
                <flux:label>Banner Name</flux:label>
                <flux:input wire:model="name" type="text" placeholder="Enter banner name" />
            </div>

            <div>
                <flux:label>Start Show</flux:label>
                <flux:input wire:model="startShow" type="datetime-local" />
            </div>

            <div>
                <flux:label>End Show</flux:label>
                <flux:input wire:model="endShow" type="datetime-local" />
            </div>

            <div class="flex gap-2">
                <flux:button type="submit" variant="primary">{{ $banner ? 'Update Banner' : 'Create Banner' }}
                </flux:button>
                <flux:button as href="{{ route('banners.index') }}" variant="ghost">Cancel</flux:button>
            </div>
        </form>
    </flux:container-sidebar>
</div>
