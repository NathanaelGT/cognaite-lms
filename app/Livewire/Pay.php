<?php

namespace App\Livewire;

use App\Enums\TransactionStatus;
use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Midtrans\Config;

class Pay extends Component
{
    public Transaction $transaction;

    public function mount()
    {
        if ($this->transaction->status !== TransactionStatus::Pending) {
            return redirect(MyBatchResource::getUrl('view', [$this->transaction->batch]));
        }
    }

    public function success(string $orderId)
    {
        if ($orderId !== $this->transaction->id) {
            return;
        }

        DB::transaction(function () {
            $this->transaction->update([
                'status' => TransactionStatus::Paid,
            ]);

            Auth::user()->batches()->attach($this->transaction->batch_id);
        });

        $this->redirect(MyBatchResource::getUrl('view', [$this->transaction->batch]));
    }

    public function render()
    {
        return view('livewire.pay', ['clientKey' => Config::$clientKey])
            ->title("Pembayaran Batch {$this->transaction->batch->name}");
    }
}
