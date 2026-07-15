<?php

namespace App\Livewire;

use App\Models\Alamat;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddressCreate extends Component
{
    public $title;
    public $id;
    public $provinces = [];
    public $regencies = [];
    public $districts = [];
    public $villages = [];

    #[Validate("required")]
    public $province_id;
    #[Validate("required")]
    public $regency_id;
    #[Validate("required")]
    public $district_id;
    #[Validate("required")]
    public $village_id;

    #[Validate("required")]
    public $nama = '';

    #[Validate("required")]
    public $phone = '';
    #[Validate("required")]
    public $alamat = '';

    public $province = '';
    public $regency = '';
    public $district = '';
    public $village = '';

    #[Validate("required")]
    public $default = false;
    #[Validate("required")]
    public $postal_code = '';



    public function request($url)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'accept' => 'application/json',
                'key' => env('RAJAONGKIR_SHIPPING_COST'),
            ],
        ]);

        $body = $response->getBody()->getContents();

        $result = json_decode($body, true);

        return collect($result['data']);
    }

    public function getProvinceData()
    {

        $this->provinces = $this->request('https://rajaongkir.komerce.id/api/v1/destination/province');

        // dd($this->provinces);
    }

    public function getRegenciesData()
    {
        $this->regencies = $this->request('https://rajaongkir.komerce.id/api/v1/destination/city/' . $this->province_id);
    }

    public function getDistrictData()
    {
        $this->districts = $this->request('https://rajaongkir.komerce.id/api/v1/destination/district/' . $this->regency_id);
    }

    public function getVillageData()
    {
        $this->villages = $this->request('https://rajaongkir.komerce.id/api/v1/destination/sub-district/' . $this->district_id);
    }

    public function updatedProvinceId($value)
    {

        // $this->province_id = $this->provinces->firstWhere('name', $this->province)['id'];
        // dd($this->province_id);
        $this->getRegenciesData();

        $this->regency = null;
        $this->districts = [];
        $this->district = null;
        $this->villages = [];
        $this->village = null;
        $this->postal_code = null;
    }

    public function updatedRegencyID($value)
    {
        // $this->regency_id = $this->regencies->firstWhere('name', $this->regency)['id'];

        $this->getDistrictData();

        $this->district = null;
        $this->villages = [];
        $this->village = null;
        $this->postal_code = null;
    }

    public function updatedDistrictID($value)
    {

        // $this->district_id = $this->districts->firstWhere('name', $this->district)['id'];

        $this->getVillageData();
        $this->village = null;
        $this->postal_code = null;
    }

    public function updatedVillageID($value)
    {
        $village = $this->villages->firstWhere('id', $value);
        // $this->village_id = $village['id'];
        $this->postal_code = $village ? $village['zip_code'] : '';

        // dd($this->province_id, $this->regency_id, $this->district_id, $this->postal_code, $village['zip_code'], $this->villages);
    }



    #[On("tambahAlamat")]
    public function openCreateModal()
    {
        $this->reset(['nama', 'phone', 'alamat', 'province', 'regency', 'district', 'village', 'postal_code', 'default', 'province_id', 'regency_id', 'district_id', 'village_id']);
        $this->id = null;
        $this->provinces = [];
        $this->regencies = [];
        $this->districts = [];
        $this->villages = [];
        $this->default = false;
        $this->title = "Tambah Alamat";
        $this->dispatch('modal-close', name: 'hapus-alamat');
        $this->dispatch('modal-show', name: "tambah-alamat");
    }

    #[On("editAlamat")]
    public function openEditModal($id)
    {
        $alamat = Alamat::find($id);

        if (!$alamat) {
            return;
        }

        $this->getProvinceData();
        // $this->getRegenciesData();
        // $this->getDistrictData();
        // $this->getVillageData();

        $this->id = $alamat->id;
        $this->nama = $alamat->nama;
        $this->phone = $alamat->phone;
        $this->alamat = $alamat->alamat;
        $this->province = $alamat->province;
        $this->regency = $alamat->regency;
        $this->district = $alamat->district;
        $this->village = $alamat->village;
        $this->province_id = $alamat->province_id;
        $this->regency_id = $alamat->regency_id;
        $this->district_id = $alamat->district_id;
        $this->village_id = $alamat->village_id;
        $this->postal_code = $alamat->postal_code;
        $this->default = $alamat->default;
        $this->title = "Edit alamat";
        $this->dispatch('modal-close', name: 'hapus-alamat');
        $this->dispatch('modal-show', name: "tambah-alamat");
    }

    public function tutupModal()
    {
        $this->dispatch('modal-close', name: 'tambah-alamat');
        $this->dispatch('modal-close', name: 'hapus-alamat');
    }

    public function save()
    {
        $user = Auth::user();
        $validated = $this->validate();
        $validated['user_id'] = $user->id;
        $validated['province'] = $this->provinces->firstWhere('id', $this->province_id)['name'];
        $validated['regency'] = $this->regencies->firstWhere('id', $this->regency_id)['name'];
        $validated['district'] = $this->districts->firstWhere('id', $this->district_id)['name'];
        $validated['village'] = $this->villages->firstWhere('id', $this->village_id)['name'];

        if ($this->default) {
            Alamat::where('user_id', $user->id)
                ->where('default', true)
                ->update(['default' => false]);
        }

        try {
            Alamat::updateOrCreate(['id' => $this->id], $validated);

            $this->dispatch('modal-close', name: 'tambah-alamat');
            $this->dispatch('updateAlamat', message: $this->id ? "Alamat berhasil diperbaharui" : "Alamat Berhasil Dibuat");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function openDeleteModal()
    {
        $this->dispatch('modal-show', name: "hapus-alamat");
        $this->dispatch('modal-close', name: 'tambah-alamat');
    }

    public function deleteAlamat($id)
    {
        Alamat::find($id)->delete();
        $this->dispatch('modal-close', name: 'tambah-alamat');
        $this->dispatch('modal-close', name: 'hapus-alamat');
        $this->dispatch('updateAlamat', message: "Alamat berhasil dihapus");
    }

    public function render()
    {
        return view('livewire.address-create');
    }
}
