<?php

namespace App\Livewire;

use App\Models\Transaction;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;

class Payment extends Component
{
    public $transaction;
    public $snapToken;

    public function mount($slug)
    {
        try {
            $this->transaction = Transaction::where('slug', $slug)->first();

            // dd($this->transaction);

            // if (!$this->transaction) {
            //     throw new Exception("Sorry, Your order not found!");
            // }

            Config::$serverKey = config('midtrans.serverKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = config('midtrans.isSanitized');
            Config::$is3ds = config('midtrans.is3ds');


            if (!$this->transaction->snap_token) {

                $midtransParams = [
                    'transaction_details' => [
                        'order_id' => $this->transaction->transaction_number,
                        'gross_amount' => $this->transaction->total,
                    ],
                    'customer_details' => [
                        'first_name' => $this->transaction->pengiriman->name,
                        'phone' => $this->transaction->pengiriman->phone,
                        'email' => $this->transaction->user->email,

                        // 'address' => $this->transaction->shipping->address,
                    ],
                ];
                $this->snapToken = Snap::getSnapToken($midtransParams);

                $this->transaction->snap_token = $this->snapToken;
                $this->transaction->save();
            } else {
                $this->snapToken = $this->transaction->snap_token;
            }

            // dd($this->snapToken);
        } catch (\Throwable $th) {
            throw $th;
            return redirect(route('history.index'))->with('error', $th->getMessage());

        }

    }

    public function render()
    {
        return view('livewire.payment')->layout('components.layouts.invoice', ['title' => "Payment {$this->transaction->terbransaction_number}"]);
    }
}
