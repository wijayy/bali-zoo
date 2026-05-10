<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Transaction;
use Illuminate\Http\Request;

class XenditCallbackController extends Controller
{
    public function invoice(Request $request)
    {
        $webhookToken = config('xendit.webhook_token');

        if ($webhookToken && !hash_equals($webhookToken, (string) $request->header('x-callback-token'))) {
            return response()->json(['message' => 'Invalid webhook token'], 401);
        }

        $payload = $request->all();

        logger()->info('Xendit invoice webhook:', $payload);

        $externalId = data_get($payload, 'external_id', data_get($payload, 'data.external_id'));
        $status = strtoupper((string) data_get($payload, 'status', data_get($payload, 'data.status')));
        $paymentMethod = data_get($payload, 'payment_method', data_get($payload, 'data.payment_method', 'Xendit'));

        $transaction = Transaction::where('transaction_number', $externalId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        if (in_array($status, ['PAID', 'SETTLED'], true)) {
            Pembayaran::updateOrCreate(
                ['transaction_id' => $transaction->id],
                [
                    'metode_pembayaran' => 'Xendit' . ($paymentMethod ? " ({$paymentMethod})" : ''),
                    'status' => 'paid',
                ]
            );

            $transaction->update(['status' => 'paid']);
        }

        if ($status === 'EXPIRED' && $transaction->status === 'ordered') {
            $transaction->update(['status' => 'expired']);
        }

        return response()->json(['message' => 'Webhook diterima']);
    }
}
