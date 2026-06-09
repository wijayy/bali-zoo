<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $users = User::where('is_admin', 1)->get();

        return view("user.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("user.create", ['user' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                "name" => "required|string",
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed',
                'is_superadmin' => 'required'
            ]
        );

        try {
            DB::beginTransaction();
            $validated['password'] = Hash::make($validated['password']);
            $validated['is_admin'] = 1;
            User::create($validated);
            DB::commit();
            return redirect(route('admin.index'))
                ->with('success', 'New Admin Registered');
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
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        return view("user.create", ['user' => $admin]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin)
    {
        $validated = $request->validate(
            [
                "name" => "required|string",
                'email' => 'required|email|unique:users,email,' . $admin->id,
                'is_superadmin' => 'required',
                'password' => 'nullable|confirmed'
            ]
        );


        try {
            DB::beginTransaction();
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                $validated['password'] = $admin->password;
            }
            $validated['is_admin'] = 1;
            $admin->update($validated);
            DB::commit();
            return redirect(route('admin.index'))
                ->with('success', 'Admin Updated');
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
    public function destroy(User $admin)
    {
        $admin->delete();
        return redirect(route('admin.index'))
            ->with('success', 'Admin Deleted');
    }
}
