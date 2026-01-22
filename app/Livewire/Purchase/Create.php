<?php

namespace App\Livewire\Purchase;

use App\Models\Product;
use App\Models\Purchase;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public $products;
    public $items = [];
    public $total;

    public function addItems()
    {
        $this->items[] = [
            'product_id' => null,
            'qty' => 1,
            'price' => 0,
            'subtotal' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->items as $item) {
            $this->total += $item['subtotal'];
        }
    }

    public function changeItem($index)
    {
        $productId = $this->items[$index]['product_id'];
        if ($productId) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $this->items[$index]['price'] = $product->buy_price;
            }
        }

        // Hitung subtotal
        $qty = $this->items[$index]['qty'];
        $price = $this->items[$index]['price'];
        $this->items[$index]['subtotal'] = $qty * $price;

        $this->calculateTotal();
    }

    #[Validate('required|string')]
    public $purchase_number = '';

    #[Validate('required')]
    public $purchase_date = '';

    #[Validate('required')]
    public $payment_method = '';

    public function mount()
    {
        $this->products = \App\Models\Product::all();
        $this->purchase_number = Purchase::generatePurchaseNumber();
        $this->addItems();
        $this->calculateTotal();
    }

    public function save()
    {
        $this->validate();

        $purchase = Purchase::create([
            'purchase_number' => $this->purchase_number,
            'purchase_date' => $this->purchase_date,
            'total' => $this->total,
            'payment_method' => $this->payment_method,
            'status' => 'pending', // or whatever default
        ]);

        foreach ($this->items as $item) {
            $purchase->items()->create([
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);

            Product::find($item['product_id'])->increment('stock', $item['qty']);
        }

        session()->flash('message', 'Purchase created successfully.');

        return redirect()->route('purchase.index'); // assuming there's an index route
    }

    public function render()
    {
        return view('livewire.purchase.create')->layout('components.layouts.app', ['title' => 'Create Purchase']);
    }
}
