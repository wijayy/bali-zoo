<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Payment extends Component
{
    public $transaction;
    public $paymentUrl;

    public function mount($slug)
    {
        try {
            $this->transaction = Transaction::with(['couponUsage', 'items.product.category', 'pengiriman', 'user'])
                ->where('slug', $slug)
                ->firstOrFail();

            if (!$this->transaction->xendit_invoice_url) {
                $this->createInvoice();
            }

            $this->paymentUrl = $this->transaction->xendit_invoice_url;
        } catch (\Throwable $th) {
            return redirect(route('history.index'))->with('error', $th->getMessage());
        }
    }

    public function createInvoice()
    {
        $secretKey = config('xendit.secret_key');

        if (!$secretKey) {
            throw new \RuntimeException('XENDIT_SECRET_KEY belum dikonfigurasi.');
        }

        $response = Http::withBasicAuth($secretKey, '')
            ->acceptJson()
            ->post(config('xendit.base_url') . '/v2/invoices', [
                'external_id' => $this->transaction->transaction_number,
                'amount' => (int) $this->transaction->total,
                'description' => "Payment for {$this->transaction->transaction_number}",
                'invoice_duration' => config('xendit.invoice_duration'),
                'currency' => config('xendit.currency'),
                'customer' => [
                    'given_names' => $this->transaction->pengiriman->name,
                    'email' => $this->transaction->user->email,
                    'mobile_number' => $this->formatPhoneNumber($this->transaction->pengiriman->phone),
                ],
                'items' => $this->transaction->items->map(fn ($item) => [
                    'name' => $item->product->name,
                    'quantity' => (int) $item->qty,
                    'price' => (int) $item->price,
                    'category' => optional($item->product->category)->name,
                ])->values()->all(),
                'success_redirect_url' => route('history.index'),
                'failure_redirect_url' => route('payment.index', $this->transaction->slug),
            ]);

        if ($response->failed()) {
            logger()->error('Xendit invoice creation failed:', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            throw new \RuntimeException('Gagal membuat invoice Xendit.');
        }

        $invoice = $response->json();

        $this->transaction->update([
            'xendit_invoice_id' => $invoice['id'] ?? null,
            'xendit_invoice_url' => $invoice['invoice_url'] ?? null,
        ]);
    }

    private function formatPhoneNumber(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        $phone = preg_replace('/\D+/', '', $phone);

        if (str_starts_with($phone, '0')) {
            return '+62' . substr($phone, 1);
        }

        if (str_starts_with($phone, '62')) {
            return '+' . $phone;
        }

        return $phone;
    }

    public function render()
    {
        return view('livewire.payment')->layout('components.layouts.invoice', ['title' => "Payment {$this->transaction->transaction_number}"]);
    }
}
