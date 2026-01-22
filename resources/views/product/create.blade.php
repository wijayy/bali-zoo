@php
    $title = $product ?? false ? "Edit product $product->name" : 'Add new product';
@endphp

<x-auth-layout title="{{ $title }}">
    {{-- <div class="lg:text-lg font-semibold">{{ $title }} </div> --}}

    <form enctype="multipart/form-data"
        action="{{ $product ?? false ? route('products.update', ['product' => $product->slug]) : route('products.store') }}"
        method="post" class="mt-4">
        @csrf
        @if ($product ?? false)
            @method('put')
        @endif
        <x-label>Product Photos</x-label>
        <div x-data="{
            items: [
                { file: '{{ $product->image1 ?? false ? asset("storage/$product->image1") : '' }}' }, { file: '{{ $product->image2 ?? false ? asset("storage/$product->image2") : '' }}' }, { file: '{{ $product->image3 ?? false ? asset("storage/$product->image3") : '' }}' }, { file: '{{ $product->image4 ?? false ? asset("storage/$product->image4") : '' }}' }
            ],
        
            addItem() {
                this.items.push({
                    file: '',
        
                });
            },
            removeItem(index) {
                this.items.splice(index, 1);
            }
        }" class="mt-4 space-y-2">
            <!-- Input Fields -->
            <div class="grid items-end gap-2 grid-cols-4 ">
                <template x-for="(item, index) in items" :key="index">
                    <div class="relative" x-data="{
                        image: item.file,
                        text: 'image ' + (index + 1),
                        label: 'image' + (index + 1),
                        lbl: !item.file,
                        fileName: '',
                        imagePreview(event) {
                            const files = event.target.files[0];
                            if (!files) {
                                this.lbl = true;
                                return;
                            }
                            if (files.type.startsWith('image/')) {
                                this.image = URL.createObjectURL(files);
                                this.fileName = ''; // Reset file name jika gambar
                            } else {
                                this.image = ''; // Reset image jika bukan gambar
                                this.fileName = file.name; // Simpan nama file
                            }
                            this.lbl = false;
                        }
                    }">
                        {{-- <x-label :required="true" ::for="label" x-text="text" /> --}}
                        <div class="relative flex w-full mt-1 text-center rounded-md shadow-md aspect-square">
                            <img :src="image" :alt="text"
                                class="absolute top-0 left-0 z-10 object-cover rounded-md size-full" x-show="image">
                            <!-- Tampilkan Nama File Jika Bukan Gambar -->
                            <span
                                class="absolute text-gray-700 transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                x-show="fileName" x-text="fileName"></span>
                            <input type="file" :id="label" :name="label"
                                @change="imagePreview(event)" class="sr-only">
                            <label :for="label" :class="{ 'opacity-100': (lbl), 'opacity-0': !lbl }"
                                class="absolute top-0 left-0 z-20 flex items-center justify-center w-full h-full bg-transparent border border-black border-dashed rounded-md cursor-pointer text-sky-500 hover:text-blue-700"
                                x-text="text"></label>
                        </div>

                    </div>
                </template>
            </div>

            <div class="grid items-end gap-2 grid-cols-5">
                <div class="">
                    <x-input-error for="image1" class="mt-2" />
                </div>
                <div class="">
                    <x-input-error for="image2" class="mt-2" />
                </div>
                <div class="">
                    <x-input-error for="image3" class="mt-2" />
                </div>
                <div class="">
                    <x-input-error for="image4" class="mt-2" />
                </div>
                <div class="">
                    <x-input-error for="image5" class="mt-2" />
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 mt-4 gap-4 md:grid-cols-2">
            <div class="">
                <x-label required="true" for="name" value="{{ __('Product Name') }}" />
                <x-input value="{{ old('name', $product->name ?? false) }}" id="name" type="text"
                    class="mt-1 block w-full" name="name" required autocomplete="name" />
                <x-input-error for="name" class="mt-2" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="">
                    <x-label required="true" for="category_id" value="{{ __('category') }}" />
                    <x-form-select id="category_id" type="text" class="mt-1 block w-full" name="category_id" required
                        autocomplete="category_id">
                        @foreach ($categories as $item)
                            <x-form-option value="{{ $item->id }}"
                                selected="{{ old('category_id', $product->category_id ?? false) == $item->id }}">{{ $item->name }}
                            </x-form-option>
                        @endforeach
                    </x-form-select>
                    <x-input-error for="category_id" class="mt-2" />
                </div>
                <div class="">
                    <x-label required="true" for="supplier_id" value="{{ __('supplier') }}" />
                    <x-form-select id="supplier_id" type="text" class="mt-1 block w-full" name="supplier_id" required
                        autocomplete="supplier_id">
                        @foreach ($suppliers as $item)
                            <x-form-option value="{{ $item->id }}"
                                selected="{{ old('supplier_id', $product->supplier_id ?? false) == $item->id }}">{{ $item->name }}
                            </x-form-option>
                        @endforeach
                    </x-form-select>
                    <x-input-error for="supplier_id" class="mt-2" />
                </div>
            </div>
            <div class="md:col-span-2 flex gap-4">
                <div class="w-3/4">
                    <x-label required="true" for="length" value="{{ __('Dimension (cm)') }}" />
                    <div class="grid-cols-3  gap-4 grid">
                        <div class="">
                            <x-input value="{{ old('length', $product->length ?? false) }}" id="length"
                                type="number" class="mt-1 block w-full" name="length" required autocomplete="length"
                                placeholder="Length" />
                            <x-input-error for="length" class="mt-2" />
                        </div>
                        <div class="">
                            <x-input value="{{ old('width', $product->width ?? false) }}" id="width" type="number"
                                class="mt-1 block w-full" name="width" required autocomplete="width"
                                placeholder="width" />
                            <x-input-error for="width" class="mt-2" />
                        </div>
                        <div class="">
                            <x-input value="{{ old('height', $product->height ?? false) }}" id="height"
                                type="number" class="mt-1 block w-full" name="height" required
                                autocomplete="height" placeholder="height" />
                            <x-input-error for="height" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="w-1/4">
                    <x-label required="true" for="weight" value="{{ __('weight (Kg)') }}" />
                    <x-input value="{{ old('weight', $product->weight ?? false) }}" id="weight" type="text"
                        class="mt-1 block w-full" name="weight" required autocomplete="weight" />
                    <x-input-error for="weight" class="mt-2" />
                </div>
            </div>
            <div class="grid gap-4 grid-cols-3 col-span-2">
                <div class="">
                    <x-label required="true" for="sell_price" value="{{ __('sell price') }}" />
                    <x-input value="{{ old('sell_price', $product->sell_price ?? false) }}" id="sell_price"
                        type="text" class="mt-1 block w-full" name="sell_price" required
                        autocomplete="sell_price" />
                    <x-input-error for="sell_price" class="mt-2" />
                </div>
                <div class="">
                    <x-label required="true" for="buy_price" value="{{ __('buy price') }}" />
                    <x-input value="{{ old('buy_price', $product->buy_price ?? false) }}" id="buy_price"
                        type="text" class="mt-1 block w-full" name="buy_price" required
                        autocomplete="buy_price" />
                    <x-input-error for="buy_price" class="mt-2" />
                </div>
                <div class="">
                    <x-label required="true" for="stock" value="{{ __('stock') }}" />
                    <x-input value="{{ old('stock', $product->stock ?? 0) }}" id="stock" readonly type="text"
                        class="mt-1 block w-full" name="stock" required autocomplete="stock" />
                    <x-input-error for="stock" class="mt-2" />
                </div>
            </div>
            <div class="col-span-1 md:col-span-2">
                <x-label required="true" for="description" value="{{ __('description') }}" />
                <x-input value="{{ old('description', $product->description ?? false) }}" id="description"
                    type="hidden" class="mt-1 block w-full" name="description" required
                    autocomplete="description" />
                <trix-editor input="description"></trix-editor>
                <x-input-error for="description" class="mt-2" />
            </div>
        </div>

        <div class="flex justify-center mt-4">
            <flux:button type="submit" :variant="'underline'">Submit</flux:button>
        </div>

    </form>
</x-auth-layout>
