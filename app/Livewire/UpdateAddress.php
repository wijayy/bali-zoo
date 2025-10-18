<?php

namespace App\Livewire;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Models\Village;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Livewire component for updating the user's address.
 */
class UpdateAddress extends Component
{
    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [
        'province_id' => null,
        'regency_id' => null,
        'district_id' => null,
        'village_id' => null,
        'alamat' => '',
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

        $this->state = $user->only(
            [
                'address',
                'province_id',
                'regency_id',
                'district_id',
                'village_id',
            ]
        );

        $this->provinces = Province::all();

        if ($user->province_id) {
            $this->regencies = Regency::where('province_id', $user->province_id)->get();
        }

        if ($user->regency_id) {
            $this->districts = District::where('regency_id', $user->regency_id)->get();
        }

        if ($user->district_id) {
            $this->villages = Village::where('district_id', $user->district_id)->get();
        }
    }

    /**
     * Handle event when the province is updated.
     *
     * @param  int|null  $value
     * @return void
     */
    public function updatedStateProvinceId($value)
    {

        logger('Province changed to: ' . $value);
        $this->regencies = Regency::where('province_id', $value)->get();
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
        $this->districts = District::where('regency_id', $value)->get();
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
        $this->villages = Village::where('district_id', $value)->get();
        $this->state['village_id'] = null;
    }

    /**
     * Update the user's address.
     *
     * @return void
     */
    public function submit()
    {
        $validated = $this->validate(
            [
                'state.address' => 'required|string|max:255',
                'state.province_id' => 'required|exists:provinces,id',
                'state.regency_id' => 'required|exists:regencies,id',
                'state.district_id' => 'required|exists:districts,id',
                'state.village_id' => 'required|exists:villages,id',
            ]
        );

        logger("submited {$validated['state']['address']}");

        Auth::user()->forceFill([
            'address' => $validated['state']['address'],
            'province_id' => $validated['state']['province_id'],
            'regency_id' => $validated['state']['regency_id'],
            'district_id' => $validated['state']['district_id'],
            'village_id' => $validated['state']['village_id'],
        ])->save();

        $this->dispatch('saved');
        // session()->flash('message', 'Alamat berhasil diperbarui!');
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.update-address')->layout('layouts.auth', ['title' => "Address"]);
    }
}
