<?php

namespace App\Livewire;

use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CouponIndex extends Component
{

    public $title = "All Coupon";

    public $coupons;

    public function mount()
    {
        $this->getCoupon();
    }

    public function getCoupon()
    {

        $this->coupons = Coupon::all();
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $coupon = Coupon::where('id', $id)->first();

            if ($coupon) {
                $coupon->delete();
            }
            DB::commit();
            $this->dispatch('modal-close')
            $this->getCoupon();
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
        return view('livewire.coupon-index')->layout('layouts.auth', ['title' => $this->title]);
    }
}
