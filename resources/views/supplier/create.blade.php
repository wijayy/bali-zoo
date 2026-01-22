<form enctype="multipart/form-data" wire:submit='save' class="bg-white rounded-lg p-4">
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <flux:input wire:model='name' label="Name" type="text" required></flux:input>
        <flux:input wire:model='address' label="Address" type="text" required></flux:input>
        <flux:input wire:model='person' label="Contact Person" type="text" required></flux:input>
        <flux:input wire:model='email' label="Email" type="text" required></flux:input>
        <flux:input wire:model='phone' label="Phone Number" type="text" required></flux:input>
    </div>

    <div class="mt-4">
        <flux:button type="submit">Submit</flux:button>
    </div>
</form>
