<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponProduct;
use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use App\Models\Province;
use App\Models\Transaction;
use AzisHapidin\IndoRegion\RawDataGetter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;

class Checkout extends Component
{

    public $title = "Checkout", $carts, $subtotal, $shipment = null, $client;
    public $chargeable_weight = 0, $coupon, $message = '', $c, $weight = 0, $length = 0, $width = 0, $height = 0, $total_actual_weight = 0, $total_volumetric_weight = 0, $province, $city, $district, $village;
    public $totalLength = 0, $maxWidth = 0, $maxHeight = 0;

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|starts_with:0')]
    public $phone = '';

    #[Validate('required|email')]
    public $email = '';


    #[Validate('required')]
    public $shipment_id = '', $province_id, $regency_id, $district_id, $village_id, $address, $postal_code;

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

        if ($this->subtotal > $this->c->minimum) {
            if ($this->c->type == 'fixed') {
                return $this->c->amount;
            } else {
                $discount = 0;
                foreach ($this->carts as $key => $item) {
                    $link = CouponProduct::where('coupon_id', $this->c->id)->where('product_id', $item->product->id)->first();

                    if ($link) {
                        $discount += $this->c->amount / 100 * $item->product->price * $item->qty;
                    }
                }
                if ($this->c->maximum > 0) {
                    $discount = min($discount, $this->c->maximum);
                }
                return $discount;
            }
        }
        return 0;
    }

    public $shipments = [

    ];

    /**
     * The available provinces.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $provinces;

    /**
     * The available regencies for the selected province.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $regencies = [];

    /**
     * The available districts for the selected regency.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $districts = [];

    /**
     * The available villages for the selected district.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $villages = [];

    /**
     * Mount the component and initialize the state.
     *
     * @return void
     */
    public function mount()
    {
        // dd(RawDataGetter::getProvinces());
        $user = Auth::user();

        $this->name = $user->name;
        $this->phone = $user->phone;

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://rajaongkir.komerce.id/api/v1/destination/province', [
            'headers' => [
                'accept' => 'application/json',
                'key' => env('RAJAONGKIR_SHIPPING_COST'),
            ],
        ]);

        // Ambil body JSON
        $body = $response->getBody()->getContents();

        // Decode ke array
        $result = json_decode($body, true);

        // dd($result);

        // Ambil bagian data
        $this->provinces = collect($result['data']);

        // $this->provinces = [];

        $this->loadCarts();
    }

    /**
     * Handle event when the province is updated.
     *
     * @param  int|null  $value
     * @return void
     */
    public function updatedProvinceId($value)
    {

        // dd($value);

        logger('Province changed to: ' . $value);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://rajaongkir.komerce.id/api/v1/destination/city/' . $value, [
            'headers' => [
                'accept' => 'application/json',
                'key' => env('RAJAONGKIR_SHIPPING_COST'),

            ],
        ]);

        // Ambil body JSON
        $body = $response->getBody()->getContents();

        // Decode ke array
        $result = json_decode($body, true);



        // Ambil bagian data
        $this->regencies = collect($result['data']);

        // $this->regencies = Regency::where('province_id', $value)->get();
        $this->regency_id = null;
        $this->districts = [];
        $this->district_id = null;
        $this->villages = [];
        $this->village_id = null;
    }

    /**
     * Handle event when the regency is updated.
     *
     * @param  int|null  $value
     * @return void
     */
    public function updatedRegencyId($value)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://rajaongkir.komerce.id/api/v1/destination/district/' . $value, [
            'headers' => [
                'accept' => 'application/json',
                'key' => env('RAJAONGKIR_SHIPPING_COST'),

            ],
        ]);

        // Ambil body JSON
        $body = $response->getBody()->getContents();

        // Decode ke array
        $result = json_decode($body, true);


        // Ambil bagian data
        $this->districts = collect($result['data']);
        $this->district_id = null;
        $this->villages = [];
        $this->village_id = null;
    }

    /**
     * Handle event when the district is updated.
     *
     * @param  int|null  $value
     * @return void
     */
    public function updatedDistrictId($value)
    {
        $this->getShipment();

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://rajaongkir.komerce.id/api/v1/destination/sub-district/' . $value, [
            'headers' => [
                'accept' => 'application/json',
                'key' => env('RAJAONGKIR_SHIPPING_COST'),

            ],
        ]);

        // Ambil body JSON
        $body = $response->getBody()->getContents();

        // Decode ke array
        $result = json_decode($body, true);


        // Ambil bagian data
        $this->villages = collect($result['data']);
        // dd($this->villages);
        $this->village_id = null;
    }

    public function updatedVillageId($value)
    {
        // dd($this->province_id, $this->regency_id, $this->district_id, $value);
        $village =$this->villages->firstWhere('id', $value);
        $this->postal_code = $village ? $village['zip_code'] : '';
    }


    public function loadCarts()
    {
        $this->carts = Cart::with('product')->where('user_id', Auth::id())->get();

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
                'destination' => $this->district_id,
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
            }

            Pengiriman::create([
                'transaction_id' => $transaksi->id,
                'name' => $this->name,
                'phone' => $this->phone,
                'address' => $this->address,
                'province' => $this->provinces->firstWhere('id', $this->province_id)['name'],
                'city' => $this->regencies->firstWhere('id', $this->regency_id)['name'],
                'district' => $this->districts->firstWhere('id', $this->district_id)['name'],
                'district_id' => $this->district_id,
                'village' => $this->villages->firstWhere('id', $this->village_id)['name'],
                'postal_code' => $this->postal_code,
                'status' => 'ordered'
            ]);

            DB::commit();

            Cart::where('user_id', Auth::id())->delete();

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
