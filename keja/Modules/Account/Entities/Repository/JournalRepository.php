<?php


namespace Modules\Account\Entities\Repository;


use Illuminate\Pipeline\Pipeline;
use Innox\Classes\QueryFilter\AccountIIdFilter;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\QueryFilter\PaymentIdFilter;
use Modules\Account\Entities\Journal;

class JournalRepository
{


    public function all()
    {
        return app(Pipeline::class)
            ->send(Journal::query())
            ->through([
                IdFilter::class,
                PaymentIdFilter::class,
                AccountIIdFilter::class,
                DateBetweenFilter::class
            ])
            ->thenReturn()
            ->get();

    }
    public function create(array $journalData)
    {

        return Journal::create([
            'account_id' => $journalData['account_id'],
            'debit' => $journalData['debit'],
            'credit' => $journalData['credit'],
            'payment_id' => $journalData['payment_id'],
            'narration' => $journalData['narration']
        ]);

    }

}
