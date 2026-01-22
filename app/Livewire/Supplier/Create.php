<?php

namespace App\Livewire\Supplier;

use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public $title = "adsadf", $id;

    #[Validate('required')]
    public $name = '', $address, $person;

    #[Validate('required|email')]
    public $email;

    #[Validate('required|doesnt_start_with:0', message: ['doenst_start_with' => 'Phone number cannot start with 0'])]
    public $phone;

    public function mount($slug = null)
    {
        if ($slug) {
            $this->title = "Edit Supplier";
            $supplier = \App\Models\Supplier::where('slug', $slug)->first();
            $this->id = $supplier->id;
            $this->name = $supplier->name;
            $this->address = $supplier->address;
            $this->person = $supplier->person;
            $this->email = $supplier->email;
            $this->phone = $supplier->phone;
        } else {
            $this->title = "Add Supplier";
            $this->name = '';
            $this->address = '';
            $this->person = '';
            $this->email = '';
            $this->phone = '';
        }

    }

    public function save()
    {
        $validated = $this->validate();

        try {
            DB::beginTransaction();
            Supplier::updateOrCreate(
                ['id' => $this->id],
                [
                    'name' => $this->name,
                    'address' => $this->address,
                    'person' => $this->person,
                    'email' => $this->email,
                    'phone' => $this->phone,
                ]
            );
            DB::commit();
            session()->flash('message', 'Supplier saved successfully.');
            return redirect()->route('suppliers.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                session()->flash('error', $th->getMessage());
            }
        }
    }

    public function render()
    {
        return view('supplier.create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
