<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(request('paginate'));
        $categories = Category::all();
        $products = Product::withCount('review')->filters(request(['category', 'min', 'max', 'search']))->paginate(12);
        return view("shop.index", compact("products", "categories"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $shop)
    {
        $product = $shop;
        $products = Product::whereNot('id', $product->id)->filters(['category' => $product->category->slug])->take(4)->get();
        return view("shop.show", compact("product", "products"));
    }
}
