<?php

namespace App\Observers;

use App\DB\Lease\Payment;
use Illuminate\Support\Facades\DB;
use Innox\Classes\Handlers\AdvantaMessageHandler;
use Modules\Account\Entities\Repository\AccountRepository;
use Modules\Account\Entities\Repository\JournalRepository;

class PaymentObserver
{
    public function created(Payment $payment)
    {

       if ( isset($payment->lease->tenant->name))
        {
            $message = setting('payment_notification_sms');
            $message = str_replace('{tenant}',$payment->lease->tenant->name, $message );
            $message = str_replace('{amount}',$payment->amount, $message );
            $message = str_replace('{room_number}',$payment->lease->tenant->getUnitNumber(), $message );
            if (isset($payment->lease->tenant->room->building->name))
            {
                $message = str_replace('{building}',$payment->lease->tenant->room->building->name, $message );
            }

            (new AdvantaMessageHandler())->send($payment->lease->tenant->phone_number, $message);
        }


       $this->createJournal($payment);

    }

    private function createJournal(Payment $payment)
    {

        try {
            DB::beginTransaction();

            $bankAccount = (new AccountRepository())->findByCode('A010101');

            //debit
            (new JournalRepository())
                ->create([
                    'account_id' => $bankAccount->id,
                    'debit' => $payment->amount,
                    'credit' => 0,
                    'payment_id' => $payment->id,
                    'narration' => "Rent payment"
                ]);

            //credit rent Account

            $rentAccount = (new AccountRepository())->findByCode('A010106');

            (new JournalRepository())
                ->create([
                    'account_id' => $rentAccount->id,
                    'debit' => 0,
                    'credit' => $payment->amount,
                    'payment_id' => $payment->id,
                    'narration' => "Payment for the rent"
                ]);
            DB::commit();

        }catch (\Exception $exception)
        {
            DB::rollBack();
        }

    }
}
