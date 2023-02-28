<?php


namespace Innox\Classes\Repository;


use App\DB\Payment\MpesaTransaction;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Modules\Account\Entities\Repository\JournalRepository;

class MpesaRepository
{

    public function filter()
    {
        return app(Pipeline::class)
            ->send(MpesaTransaction::query())
            ->through([
                IdFilter::class,
                DateBetweenFilter::class
            ])
            ->thenReturn()
            ->get();
    }

    public function store(Request $request)
    {
        MpesaTransaction::create([
            "transaction_type" =>  $request['TransactionType'],
            "trans_id" => $request['TransID'],
            "trans_time" => $request['TransTime'],
            "Trans_amount" => $request['TransAmount'],
            "business_short_code" => $request['BusinessShortCode'],
            "bill_ref_number" => $request['BillRefNumber'],
            "invoice_number" => $request['InvoiceNumber'],
            "org_account_balance" => $request['OrgAccountBalance'],
            "third_party_trans_id" => $request['ThirdPartyTransID'],
            "MSISDN" =>  $request['MSISDN'],
            "first_name" => $request['FirstName'],
            "middle_name" => $request['MiddleName'],
            "last_name" =>  $request['LastName']
        ]);



    }
}

