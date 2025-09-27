<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        $title = "Our Suppliers";

        return view('supplier.index', compact('suppliers', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier = null;
        return view('supplier.create', compact('supplier'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            Supplier::create($validated);
            DB::commit();
            return redirect()->route('suppliers.index')->with('success', 'Supplier successfully added');
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
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.create', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $supplier->update($validated);
            DB::commit();
            return redirect()->route('suppliers.index')->with('success', "$supplier->name successfully modified");
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
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            DB::beginTransaction();
            $supplier->delete();
            DB::commit();
            return redirect()->route('suppliers.index')->with('success', 'Supplier successfully deleted');
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
