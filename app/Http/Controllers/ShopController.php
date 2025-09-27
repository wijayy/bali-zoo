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
        $products = Product::withCount('review')->filters(request(['category', 'search', 'sort']))->paginate(request('paginate', 24))->appends(request()->all());
        return view("shop.index", compact("products"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $shop)
    {
        $product = $shop;
        return view("shop.show", compact("product"));
    }
}