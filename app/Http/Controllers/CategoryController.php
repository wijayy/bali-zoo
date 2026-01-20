<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $title = 'Our Categories';

        return view('category.index', compact('categories', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = null;
        return view("category.create", compact("category"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $newImage = $request->file("image")->store("category");
            $validated['image'] = $newImage;
            $category = Category::create($validated);
            DB::commit();
            return redirect(route('categories.index'))->with('success', 'Category successfully added');
        } catch (\Throwable $th) {
            DB::rollBack();
            Storage::delete($newImage);
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.create', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        $oldImage = '';
        $newImage = '';
        try {
            DB::beginTransaction();
            if ($validated['image'] ?? false) {
                $oldImage = $category->image;
                $newImage = $request->file("image")->store("category");
                $validated['image'] = $newImage;
            }
            $category->update($validated);
            DB::commit();
            Storage::delete($oldImage);
            return redirect(route('categories.index'))->with('success', 'Category successfully edited');
        } catch (\Throwable $th) {
            DB::rollBack();
            Storage::delete($newImage);
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
    public function destroy(Category $category)
    {
        try {
            DB::beginTransaction();
            $oldImage = $category->image;
            $category->delete();
            DB::commit();
            Storage::delete($oldImage);
            return back()->with('success','category successfully deleted');
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
