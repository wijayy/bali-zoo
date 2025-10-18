<?php

namespace App\Livewire;

use App\Models\Cart as ModelsCart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{

    public $title = 'My Cart', $carts, $subtotal = 0;

    public function mount()
    {
        $this->loadCarts();

        // dd($this->carts);
    }
    public function loadCarts()
    {
        $this->carts = ModelsCart::with('product')->where('user_id', Auth::id())->get()->toArray();

        $this->subtotal = 0;

        array_walk($this->carts, function (&$item) {
            $this->subtotal += $item['qty'] * $item['product']['price'];
        });
    }

    public function updateQty($cartId, $qty)
    {
        $cart = ModelsCart::find($cartId);

        if ($cart && $cart->user_id === Auth::id()) {
            $cart->qty = (int) $qty;
            $cart->save();
        }

        $this->loadCarts();
    }

    public function delete($cartId)
    {
        $cart = ModelsCart::find($cartId);

        if ($cart && $cart->user_id === Auth::id()) {
            $cart->delete();
        }
        $this->loadCarts();
    }

    public function checkout()
    {
        $count = count($this->carts);

        if ($count > 0) {
            return redirect()->route('checkout.index');
        }
    }

    public function render()
    {
        return view('livewire.cart')->layout('layouts.app', ['title' => $this->title, 'header' => false]);
    }
}
