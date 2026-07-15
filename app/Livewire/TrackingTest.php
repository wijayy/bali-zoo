<?php

namespace App\Livewire;

use App\Services\RajaOngkirTracking;
use Livewire\Component;

class TrackingTest extends Component
{
    public string $courier = 'jne';
    public string $awb = '';
    public string $lastPhoneNumber = '';
    public ?array $trackingData = null;
    public ?string $trackingError = null;

    public function track(): void
    {
        $this->validate([
            'courier' => ['required', 'in:jne,jnt,sicepat,anteraja,pos,ninja'],
            'awb' => ['required', 'string', 'max:100'],
            'lastPhoneNumber' => [$this->courier === 'jne' ? 'required' : 'nullable', 'digits:5'],
        ]);

        $this->trackingData = null;
        $this->trackingError = null;

        try {
            $this->trackingData = app(RajaOngkirTracking::class)->track(
                $this->awb,
                $this->courier,
                $this->lastPhoneNumber,
            );
        } catch (\Throwable $e) {
            $this->trackingError = $e->getMessage();
            logger()->warning('Tracking test failed', [
                'courier' => $this->courier,
                'awb' => $this->awb,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tracking-test')
            ->layout('layouts.auth', ['title' => 'Tracking Test']);
    }
}
