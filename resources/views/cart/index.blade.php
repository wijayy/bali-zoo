<x-app-layout title="My Cart" header="true">
    <x-secondary-header :text="'Cart'" :image="asset('build/assets/jerry-wang-qBrF1yu5Wys-unsplash.jpg')">
    </x-secondary-header>

    <div class="mt-4">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 flex gap-4 min-h-96">
            <div class=" w-full lg:w-3/4">
                <div class="flex gap-4 py-2 bg-mine-400/30">
                    <div class="w-1/4 text-center font-semibold">Product</div>
                    <div class="w-1/4 text-center font-semibold">Price</div>
                    <div class="w-1/4 text-center font-semibold">Quantity</div>
                    <div class="w-1/4 text-center font-semibold">Subtotal</div>
                    <div class="w-10 text-center font-semibold"></div>
                </div>
                @php
                $total = 0;
                @endphp
                @foreach ($cart as $item)
                @php
                $total += $item->qty * $item->product->price;
                @endphp
                <div class="flex gap-4 items-center py-4">
                    <a href="{{ route('shop.show', ['shop' => $item->product->slug]) }}" class="w-1/4 text-center flex gap-1 items-center font-semibold">
                        <div class="size-20 bg-center bg-cover bg-no-repeat "
                            style="background-image: url({{ asset('storage/'. $item->product->image1) }})"></div>
                        <div class="">{{ $item->product->name }} </div>
                    </a>
                    <div class="w-1/4 text-center font-semibold">Rp.
                        {{ number_format($item->product->price, 0, ',', '.') }} </div>
                    <form action="{{ route('cart.destroy', ['cart' => $item->id]) }}" method="post"
                        class="w-1/4 text-center font-semibold">
                        @csrf
                        @method('put')
                        <x-input name="qty" type="number" class="w-8 pl-1" onchange="this.form.submit()"
                            value="{{ $item->qty }}"></x-input>
                    </form>

                    <div class="w-1/4 text-center font-semibold">Rp.
                        {{ number_format($item->qty * $item->product->price, 0, ',', '.') }} </div>
                    <form class="w-10" action="{{ route('cart.destroy', ['cart' => $item->id]) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="border-b-2 px-2 cursor-pointer" type="submit"><i
                                class="bx bx-trash"></i></button>
                    </form>
                </div>
                @endforeach
            </div>
            <div class="w-full lg:w-1/4 flex gap-4 h-fit items-center flex-col p-4 bg-mine-400/30">
                <div class="text-center text-xl font-bold ">Cart Total</div>
                <div class="text-center font-semibold">Total : <span class="text-mine-400">Rp.
                        {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a class="px-2 border-b-2" href="">Check Out</a>
            </div>
        </div>
    </div>
</x-app-layout>
