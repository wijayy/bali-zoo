<?php

namespace App\Livewire;

use App\Models\Alamat;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponProduct;

use Livewire\Component;

use App\Models\Pengiriman;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;

class Checkout extends Component
{

    public $title = "Checkout", $carts, $subtotal, $shipment = null, $client;
    public $checkoutMode = 'cart';
    public $chargeable_weight = 0, $coupon, $message = '', $c, $weight = 0, $length = 0, $width = 0, $height = 0, $total_actual_weight = 0, $total_volumetric_weight = 0, $province, $city, $district, $village;
    public $totalLength = 0, $maxWidth = 0, $maxHeight = 0;

    #[Validate("required")]
    public Alamat $selectedAlamat;


    #[Validate('required', message: "Pilih ekspedisi terlebih dahulu")]
    public $shipment_id = '';

    public function updatedCoupon()
    {
        $coupon = Coupon::where('code', $this->coupon)->first();

        if ($coupon) {
            if ($coupon->is_active()) {
                $this->c = $coupon;
                $this->message = "Coupon Applied";
            } else {
                $this->c = '';
                $this->message = "Coupon Expired";
            }
        } else {
            $this->c = '';
            $this->message = "Coupon Invalid";
        }
    }

    public function countDiscount()
    {
        if (!$this->c) {
            return 0;
        }

        if ($this->subtotal >= $this->c->minimum) {

            if ($this->c->type == 'fixed') {
                return $this->c->amount;
            }

            $discount = 0;

            $productIds = CouponProduct::where('coupon_id', $this->c->id)
                ->pluck('product_id')
                ->toArray();

            foreach ($this->carts as $item) {
                if (in_array($item->product->id, $productIds)) {
                    $discount += ($this->c->amount / 100) * $item->product->price * $item->qty;
                }
            }

            if ($this->c->maximum > 0) {
                $discount = min($discount, $this->c->maximum);
            }

            return $discount;
        }

        return 0;
    }

    public $shipments = [];



    /**
     * Mount the component and initialize the state.
     *
     * @return void
     */
    public function mount()
    {
        // dd(env('RAJAONGKIR_SHIPPING_COST'));
        $user = Auth::user();
        if ($redirect = $this->loadCarts()) {
            return $redirect;
        }

        if (count($this->address()) == 0) {
            return redirect(route('alamat.index'));
        }
        if (count($this->carts) == 0) {
            return redirect(route('shop.index'));
        }


        $this->selectedAlamat = Auth::user()->default_alamat ?? $this->address->first();


        $this->getShipment();
    }

    /**
     * Livewire does not retain relations on the unsaved Cart model used by Buy Now.
     * Rebuild it from the session before handling subsequent component requests.
     */
    public function hydrate()
    {
        if ($this->checkoutMode === 'buy_now') {
            $this->loadCarts();
        }
    }


    #[Computed()]
    public function address()
    {
        return Auth::user()->alamats;
    }

    public function openGantiAlamatModal()
    {
        $this->dispatch('modal-show', name: 'ganti-alamat');
        // dd('open');
    }

    public function gantiAlamat($id)
    {
        $this->selectedAlamat = Alamat::find($id);
        $this->getShipment();
        $this->dispatch('modal-close', name: 'ganti-alamat');
    }

    public function loadCarts()
    {
        $buyNow = session('checkout.buy_now');

        if ($buyNow) {
            $product = Product::findOrFail($buyNow['product_id']);

            if ($buyNow['qty'] > $product->stock) {
                session()->forget('checkout.buy_now');

                return redirect()->route('shop.show', $product);
            }

            $cart = new Cart([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'qty' => $buyNow['qty'],
            ]);
            $cart->setRelation('product', $product);

            $this->checkoutMode = 'buy_now';
            $this->carts = collect([$cart]);
        } else {
            $this->checkoutMode = 'cart';
            $this->carts = Cart::with('product')->where('user_id', Auth::id())->get();
        }

        $this->subtotal = 0;
        $this->total_actual_weight = 0;
        $this->total_volumetric_weight = 0;

        $this->totalLength = 0;
        $this->maxWidth = 0;
        $this->maxHeight = 0;

        $this->carts->each(function ($cart) {
            $this->subtotal += $cart->product->price * $cart->qty;

            // Pastikan data dimensi tersedia
            $length = $cart->product->length ?? 0;
            $width = $cart->product->width ?? 0;
            $height = $cart->product->height ?? 0;
            $weight = $cart->product->weight ?? 0;

            // Hitung berat aktual total (per item × qty)
            $actualWeight = $weight * $cart->qty;

            // Hitung berat volumetrik total (p x l x t x qty / divisor)
            $volumeTotal = $length * $width * $height * $cart->qty;
            $volumetricWeight = $volumeTotal / (int) env('VOLUME_DIVISOR');

            // Akumulasi total
            $this->total_actual_weight += $actualWeight;
            $this->total_volumetric_weight += $volumetricWeight;

            // Gabungkan dimensi — asumsi disusun memanjang
            $this->totalLength += $length * $cart->qty;
            $this->maxWidth = max($this->maxWidth, $width);
            $this->maxHeight = max($this->maxHeight, $height);
        });
        // Tentukan berat yang ditagihkan (chargeable)
        $this->chargeable_weight = max($this->total_actual_weight, $this->total_volumetric_weight);
    }

    public function getShipment()
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://rajaongkir.komerce.id/api/v1/calculate/district/domestic-cost', [
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/x-www-form-urlencoded',
                'key' => env('RAJAONGKIR_SHIPPING_COST'),

            ],
            'form_params' => [ // <-- ini penting, karena content-type x-www-form-urlencoded
                'origin' => '2193',
                'destination' => $this->selectedAlamat->district_id,
                'weight' => "$this->chargeable_weight",
                'courier' => 'jne:ninja:pos',
            ],
        ]);

        // Ambil body JSON
        $body = $response->getBody()->getContents();

        // Decode ke array
        $result = json_decode($body, true);

        // Ambil bagian data
        $this->shipments = $result['data'];

        // dd($this->shipments);
    }

    public function setShipment($key)
    {
        // dd($key);
        $this->shipment_id = $key;

        $this->shipment = $this->shipments[$key]['cost'];

        // dd($this->shipment);
    }

    public function save()
    {
        $this->validate();

        // dd($this->all());

        try {
            DB::beginTransaction();
            $transaksi = Transaction::create([
                'transaction_number' => Transaction::transactionNumberGenerator(),
                'total' => $this->subtotal + $this->shipment - $this->countDiscount(),
                'user_id' => Auth::id(),
                'status' => 'ordered',
                'subtotal' => $this->subtotal,
                'shipping_cost' => $this->shipment,
                'discount' => $this->countDiscount(),
            ]);

            foreach ($this->carts as $key => $value) {
                $transaksi->items()->create([
                    'product_id' => $value->product->id,
                    'qty' => $value->qty,
                    'price' => $value->product->price,
                    'subtotal' => $value->product->price * $value->qty,
                ]);
                Product::find($value->product->id)->decrement('stock', $value->qty);
            }

            Pengiriman::create([
                'transaction_id' => $transaksi->id,
                'name' => $this->selectedAlamat->nama,
                'phone' => $this->selectedAlamat->phone,
                'address' => $this->selectedAlamat->alamat,
                'province' => $this->selectedAlamat->province,
                'city' => $this->selectedAlamat->regency,
                'district' => $this->selectedAlamat->district,
                'district_id' => $this->selectedAlamat->district_id,
                'village' => $this->selectedAlamat->village,
                'postal_code' => $this->selectedAlamat->postal_code,
                'status' => 'ordered'
            ]);

            if ($this->c) {
                $transaksi->couponUsage()->create([
                    'coupon_id' => $this->c->id,
                    'discount_amount' => $this->countDiscount(),
                ]);
            }

            DB::commit();

            if ($this->checkoutMode === 'buy_now') {
                session()->forget('checkout.buy_now');
            } else {
                Cart::where('user_id', Auth::id())->delete();
            }

            return redirect(route('payment.index', $transaksi->slug));
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
        return view('livewire.checkout')->layout('layouts.app', ['title' => $this->title, 'header' => false]);
    }
}
