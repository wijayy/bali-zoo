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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;

class Checkout extends Component
{

    public $title = "Checkout", $carts, $subtotal, $shipment = 0, $client, $shipment_id = null;
    public $chargeable_weight = 0, $coupon, $message = '', $c, $weight = 0, $length = 0, $width = 0, $height = 0, $total_actual_weight = 0, $total_volumetric_weight = 0;
    public $totalLength = 0, $maxWidth = 0, $maxHeight = 0;

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|starts_with:0')]
    public $phone = '';

    #[Validate('required|email')]
    public $email = '';


    #[Validate('required')]
    public $address = '', $province = '', $city = '', $district = '', $village = '', $postal_code;

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
        [
            "name" => "Jalur Nugraha Ekakurir (JNE)",
            "code" => "jne",
            "service" => "REG",
            "description" => "Layanan Reguler",
            "cost" => 12000,
            "etd" => "2 day",
        ],
        [
            "name" => "Ninja Xpress",
            "code" => "ninja",
            "service" => "STANDARD",
            "description" => "Standard Service",
            "cost" => 13000,
            "etd" => "",
        ],
        [
            "name" => "POS Indonesia (POS)",
            "code" => "pos",
            "service" => "Pos Reguler",
            "description" => "240",
            "cost" => 13000,
            "etd" => "3 day",
        ],
        [
            "name" => "POS Indonesia (POS)",
            "code" => "pos",
            "service" => "Pos Nextday",
            "description" => "447",
            "cost" => 19000,
            "etd" => "1 day",
        ],
    ];

    public $state = [
        'province_id' => null,
        'regency_id' => null,
        'district_id' => null,
        'village_id' => null,
        'address' => '',
        'postal_code' => '',
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
        $this->provinces = $result['data'];

        // $this->provinces = [];

        $this->loadCarts();
    }

    /**
     * Handle event when the province is updated.
     *
     * @param  int|null  $value
     * @return void
     */
    public function updatedStateProvinceId($value)
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

        // dd($result);


        // Ambil bagian data
        $this->regencies = $result['data'];

        // $this->regencies = Regency::where('province_id', $value)->get();
        $this->state['regency_id'] = null;
        $this->districts = [];
        $this->state['district_id'] = null;
        $this->villages = [];
        $this->state['village_id'] = null;
    }

    /**
     * Handle event when the regency is updated.
     *
     * @param  int|null  $value
     * @return void
     */
    public function updatedStateRegencyId($value)
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
        $this->districts = $result['data'];
        $this->state['district_id'] = null;
        $this->villages = [];
        $this->state['village_id'] = null;
    }

    /**
     * Handle event when the district is updated.
     *
     * @param  int|null  $value
     * @return void
     */
    public function updatedStateDistrictId($value)
    {
        $this->getShipment();
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
                'destination' => $this->state['district_id'],
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

        try {
            DB::beginTransaction();
            $transaksi = Transaction::create([
                'transaction_number' => Transaction::transactionNumberGenerator(),
                'total' => $this->subtotal + $this->shipment - $this->countDiscount(),
                'status' => 'ordered'
            ]);

            Pengiriman::create([
                'transaction_id' => $transaksi->id,
                'name' => $this->name,
                'phone' => $this->phone,
                'address' => $this->address,
                'province' => $this->province,
                'city' => $this->city,
                'district' => $this->district,
                'district_id' => $this->district_id,
                'village' => $this->village,
                'postal_code' => $this->postal_code,
                'status' => 'ordered'
            ]);

            DB::commit();

            return redirect(route('payment.index'));
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
