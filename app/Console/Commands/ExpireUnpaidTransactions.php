<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireUnpaidTransactions extends Command
{
    protected $signature = 'transactions:expire-unpaid';

    protected $description = 'Cancel unpaid transactions that have been awaiting payment for more than 24 hours';

    public function handle(): int
    {
        $expiredAt = now()->subHours(24);
        $expiredCount = 0;

        Transaction::query()
            ->where('status', 'ordered')
            ->where('created_at', '<=', $expiredAt)
            ->select('id')
            ->orderBy('id')
            ->chunkById(100, function ($transactions) use ($expiredAt, &$expiredCount) {
                foreach ($transactions as $transaction) {
                    $didExpire = DB::transaction(function () use ($transaction, $expiredAt) {
                        $transaction = Transaction::with(['items', 'pengiriman'])
                            ->lockForUpdate()
                            ->find($transaction->id);

                        if (! $transaction || $transaction->status !== 'ordered' || $transaction->created_at->gt($expiredAt)) {
                            return false;
                        }

                        $transaction->update(['status' => 'expired']);

                        foreach ($transaction->items as $item) {
                            Product::whereKey($item->product_id)->increment('stock', $item->qty);
                        }

                        if ($transaction->pengiriman) {
                            $transaction->pengiriman->update(['status' => 'canceled']);
                        }

                        return true;
                    });

                    if ($didExpire) {
                        $expiredCount++;
                    }
                }
            });

        $this->info("{$expiredCount} unpaid transaction(s) expired.");

        return self::SUCCESS;
    }
}
