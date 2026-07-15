<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirTracking
{
    public function track(string $awb, string $courier, ?string $recipientPhone = null): array
    {
        $apiKey = config('services.rajaongkir.key');

        if (! $apiKey) {
            throw new \RuntimeException('RajaOngkir API key belum dikonfigurasi.');
        }

        $awb = trim($awb);
        $courier = strtolower(trim($courier));
        $url = 'https://rajaongkir.komerce.id/api/v1/track/waybill?' . http_build_query([
            'awb' => $awb,
            'courier' => $courier,
        ]);

        $payload = [];

        if ($courier === 'jne' && $recipientPhone) {
            $digits = preg_replace('/\D+/', '', $recipientPhone);
            $payload['last_phone_number'] = substr($digits, -5);
        }

        $response = Http::acceptJson()
            ->withHeaders(['key' => $apiKey])
            ->timeout(15)
            ->asForm()
            ->post($url, $payload);

        if ($response->failed()) {
            $message = data_get($response->json(), 'meta.message', 'Tidak dapat mengambil tracking dari RajaOngkir.');

            throw new \RuntimeException($message);
        }

        $responseData = $response->json();
        $result = data_get($responseData, 'rajaongkir.result') ?? data_get($responseData, 'data');

        if (! is_array($result)) {
            throw new \RuntimeException('Respons tracking RajaOngkir tidak valid.');
        }

        return ['rajaongkir' => ['result' => $result]];
    }
}
