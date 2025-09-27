<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::where("user_id", Auth::user()->id)->get();
        return view("cart.index", compact("cart"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $validated["user_id"] = Auth::user()->id;
            $userId = Auth::id();
            // Cek apakah produk sudah ada di cart user
            $cart = Cart::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->first();

            if ($cart) {
                // Jika sudah ada, tambahkan qty-nya
                $cart->qty += $request->qty;
                $cart->save();
            } else {
                // Jika belum ada, buat baru
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $request->product_id,
                    'qty' => $request->qty,
                ]);
            }
            DB::commit();
            return back()->with("success", "Product added to cart");
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $validated = $request->validated();

        if ($validated['qty'] == 0) {
            $cart->delete();
        }

        $cart->update($validated);

        return redirect()->back()->with('success', '');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->back();
    }
}