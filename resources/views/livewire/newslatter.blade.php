<div>
    <flux:container>

        <form wire:submit='submit' class="grid-cols-4 grid md:h-[500px] mt-8 md:px-40">
            <div class="rounded bg-cover bg-center bg-no-repeat w-full h-full"
                style="background-image: url({{ asset('assets/newslatter-l.jpg') }})"></div>
            <div class="col-span-2 flex flex-col p-4 justify-center items-center gap-4">
                <div class="font-semibold text-lg md:text-xl">Subscribe To Our Newsletter</div>
                <div class="text-center">Be the First to Discover New Products, Limited Editions, and Special Discounts from Bali Zoo — Delivered Right to You.</div>
                <flux:input wire:model.live='email' placeholder="Enter Your Email"></flux:input>
                <flux:button type="submit" variant="primary">Subscribe Now</flux:button>
            </div>
            <div class="rounded bg-cover bg-center bg-no-repeat w-full h-full"
                style="background-image: url({{ asset('assets/newslatter-r.jpg') }})"></div>
        </form>
    </flux:container>
</div>
