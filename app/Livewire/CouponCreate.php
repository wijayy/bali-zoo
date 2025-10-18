<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Product;
use Livewire\Component;
use App\Models\CouponProduct;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;

class CouponCreate extends Component
{

    public $coupon, $slug, $title, $products, $selectedProducts;

    #[Validate('required|string')]
    public $code = '';

    #[Validate('required|integer')]
    public $amount = 0;

    #[Validate('required')]
    public $type = 'fixed';

    #[Validate('required')]
    public $start_time = '';

    #[Validate('required')]
    public $end_time = '';

    #[Validate('required|integer')]
    public $minimum = 0;

    #[Validate('integer|nullable')]
    public $maximum = 0;

    #[Validate('integer')]
    public $limit = 0;

    public function mount($slug = null)
    {
        $coupon = Coupon::where('slug', $slug)->first();

        if ($coupon ?? false) {
            $this->coupon = $coupon->id;
            $this->code = $coupon->code;
            $this->amount = $coupon->amount;
            $this->type = $coupon->type;
            $this->limit = $coupon->limit;
            $this->minimum = $coupon->minimum;
            $this->maximum = $coupon->maximum;
            $this->start_time = $coupon->start_time->format('Y-m-d\TH:i');
            $this->end_time = $coupon->end_time->format('Y-m-d\TH:i');
            $this->title = "Edit coupon {$coupon->code}";
        } else {
            $this->title = "Add new coupon";
        }

        $this->products = Product::all();
        $this->selectedProducts = CouponProduct::where('coupon_id', $this->coupon)
            ->pluck('product_id')
            ->toArray();
    }

    public function toggleProduct($productId)
    {
        if (in_array($productId, $this->selectedProducts)) {
            // kalau sudah ada → hapus
            $this->selectedProducts = array_diff($this->selectedProducts, [$productId]);
        } else {
            // kalau belum ada → tambahkan
            $this->selectedProducts[] = $productId;
        }
    }

    public function selectAll()
    {
        $this->selectedProducts = collect($this->products)->pluck('id')->toArray();
    }

    public function deselectAll()
    {
        $this->selectedProducts = [];
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            // jika coupon_id ada maka update, kalau tidak create
            $coupon = Coupon::updateOrCreate(
                ['id' => $this->coupon],
                [
                    'code' => $this->code,
                    'amount' => $this->amount,
                    'type' => $this->type,
                    'limit' => $this->limit,
                    'minimum' => $this->minimum,
                    'maximum' => $this->maximum,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                ]
            );

            $coupon->products()->sync($this->selectedProducts);

            // dd($coupon);
            DB::commit();

            session()->flash('success', $this->coupon ? 'Coupon updated successfully!' : 'Coupon created successfully!');
            return redirect()->route('coupon.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }

    }
    public function render()
    {
        return view('livewire.coupon-create')->layout('layouts.auth', ['title' => $this->title]);
    }
}
