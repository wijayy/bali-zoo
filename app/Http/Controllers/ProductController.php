<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view("product.index", compact( "products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $product = null;
        return view("product.create", compact("categories", "product", 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        // dd($request->file("image1"));

        try {
            DB::beginTransaction();

            for ($i = 1; $i < 6; $i++) {
                if ($validated["image{$i}"] ?? false) {

                    $validated["image{$i}"] = $request->file("image{$i}")->store('product');
                }
            }

            $product = Product::create($validated);

            DB::commit();
            return redirect()->route("products.index")->with("success", "Product Successfuly added");
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
                $suppliers = Supplier::all();
        return view("product.create", compact("categories", "product", 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        // dd($request->file("image1"));
        $newImage = [];
        try {
            $oldImage = [];
            DB::beginTransaction();

            for ($i = 1; $i < 6; $i++) {
                if ($validated["image{$i}"] ?? false) {

                    if ($product["image{$i}"] ?? false) {
                        // dd($product);
                        $oldImage[] = $product["image{$i}"];
                    }
                    $validated["image{$i}"] = $request->file("image{$i}")->store('product');
                    $newImage[] = $validated["image$i"];
                } else {
                    $validated["image$i"] = $product["image$i"];
                }
            }

            $product->update($validated);

            DB::commit();
            foreach ($oldImage as $key => $item) {
                Storage::delete($item);
            }
            return redirect()->route("products.index")->with("success", "Product Successfuly added");
        } catch (\Throwable $th) {
            DB::rollBack();
            foreach ($newImage as $key => $item) {
                Storage::delete($item);
            }
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
            $oldImage = [];

            for ($i = 1; $i < 6; $i++) {
                if ($product["image$i"] ?? false) {
                    $oldImage[] = $product["image$i"];
                }
            }
            $product->delete();
            DB::commit();
            foreach ($oldImage as $key => $item) {
                Storage::delete($item);
            }
            return back()->with("success", "Product successfuly deleted");
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }
}
