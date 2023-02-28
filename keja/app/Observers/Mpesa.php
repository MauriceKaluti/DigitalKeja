<?php

namespace App\Observers;

use App\DB\Payment\MpesaTransaction;
use Innox\Classes\Handlers\AdvantaMessageHandler;

class Mpesa
{
    public function created(MpesaTransaction $transaction)
    {
        $amount = number_format($transaction->Trans_amount , 2);

        $message = "{$transaction->trans_id}. Dear {$transaction->full_name}. We have received {$amount}. Thank you for making your payment";

        (new AdvantaMessageHandler())
            ->send($transaction->MSISDN , $message);
    }
}
