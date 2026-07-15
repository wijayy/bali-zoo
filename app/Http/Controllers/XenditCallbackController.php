<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            DB::transaction(function () use ($transaction, $paymentMethod) {
                $transaction = Transaction::lockForUpdate()->find($transaction->id);

                if ($transaction->status !== 'ordered') {
                    return;
                }

                Pembayaran::updateOrCreate(
                    ['transaction_id' => $transaction->id],
                    [
                        'metode_pembayaran' => 'Xendit' . ($paymentMethod ? " ({$paymentMethod})" : ''),
                        'status' => 'paid',
                    ]
                );

                $transaction->update(['status' => 'paid']);
            });
        }

        if ($status === 'EXPIRED') {
            DB::transaction(function () use ($transaction) {
                $transaction = Transaction::with(['items', 'pengiriman'])
                    ->lockForUpdate()
                    ->find($transaction->id);

                if ($transaction->status !== 'ordered') {
                    return;
                }

                $transaction->update(['status' => 'expired']);

                foreach ($transaction->items as $item) {
                    Product::whereKey($item->product_id)->increment('stock', $item->qty);
                }

                if ($transaction->pengiriman) {
                    $transaction->pengiriman->update(['status' => 'canceled']);
                }
            });
        }

        return response()->json(['message' => 'Webhook diterima']);
    }
}
