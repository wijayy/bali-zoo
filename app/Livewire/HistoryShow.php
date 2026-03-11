<?php

namespace App\Livewire;

use Livewire\Component;

class HistoryShow extends Component
{
    public $transaction, $trackingSteps = [], $currentTrackingStep;
    public $trackingData = null; // response from Rajaongkir track API
    public $isSample = true; // whether we're showing bypass/sample data

    public $loadSampleData;

    // computed properties will provide tracking steps and the current step index
    public function getTrackingStepsProperty()
    {
        // you can adjust the order or labels to match your shipping workflow
        return [
            'set-pickup' => 'Menunggu penjemputan',
            'picked-up' => 'Sedang diambil',
            'in-transit' => 'Dalam perjalanan',
            'delivered' => 'Terkirim',
            'canceled' => 'Dibatalkan',
        ];
    }

    public function getCurrentTrackingStepProperty()
    {
        $status = optional($this->transaction->pengiriman)->status;
        $keys = array_keys($this->trackingSteps);
        $index = array_search($status, $keys);
        return $index === false ? -1 : $index;
    }

    public function mount($slug)
    {
        $this->loadSampleData = env('LOAD_SAMPLE_DATA', false);
        $this->transaction = \App\Models\Transaction::with([
            'pengiriman',
            'items.product',
            'payment',
            'couponUsage.coupon'
        ])
            ->where('slug', $slug)
            ->firstOrFail();

        // if we have an AWB, try to load tracking info from Rajaongkir
        if ($this->transaction->pengiriman && $this->transaction->pengiriman->awb) {
            $this->loadTracking();
        }

        if ($this->loadSampleData) {
            if (!$this->trackingData) {
                $this->trackingData = $this->sampleTrackingData();
                $this->isSample = true;
            }
        }
        // if no real tracking data obtained, fall back to a sample/bypass payload
    }

    public function render()
    {
        return view('livewire.history-show')
            ->layout('layouts.app', ['title' => 'Order Detail', 'header' => false]);
    }

    public function loadTracking()
    {
        // reset sample flag whenever we try to fetch live data
        $this->isSample = false;

        $awb = $this->transaction->pengiriman->awb;
        // default courier; you may want to store this in pengiriman later
        $courier = 'jne';

        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/track/waybill?awb={$awb}&courier={$courier}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => ['key: ' . env('RAJAONGKIR_SHIPPING_COST')],
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

            $this->trackingData = json_decode($response, true);
        } catch (\Exception $e) {
            // silently ignore or log
            logger()->error('Tracking load failed: ' . $e->getMessage());
        }
    }

    /**
     * Return a dummy tracking payload so the UI can be previewed
     * when no real data is available.
     *
     * @return array
     */
    protected function sampleTrackingData()
    {
        return [
            'rajaongkir' => [
                'query' => [
                    'waybill' => 'SAMPLE123456',
                    'courier' => 'jne',
                ],
                'status' => 200,
                'result' => [
                    'summary' => [
                        'status' => 'DELIVERED',
                        'pod_date' => now()->subDay()->toDateString(),
                        'pod_time' => now()->subDay()->format('H:i:s'),
                        'manifest' => [] // kept for compatibility
                    ],
                    'manifest' => collect([
                        ['manifest_code' => 'PU', 'manifest_description' => 'Menunggu penjemputan', 'manifest_date' => now()->subDays(3)->toDateTimeString()],
                        ['manifest_code' => 'PP', 'manifest_description' => 'Sedang diambil', 'manifest_date' => now()->subDays(2)->toDateTimeString()],
                        ['manifest_code' => 'OT', 'manifest_description' => 'Dalam perjalanan', 'manifest_date' => now()->subDay()->toDateTimeString()],
                        ['manifest_code' => 'DEL', 'manifest_description' => 'Terkirim', 'manifest_date' => now()->toDateTimeString()],
                    ])->toArray(),
                ],
            ],
        ];
    }
}
