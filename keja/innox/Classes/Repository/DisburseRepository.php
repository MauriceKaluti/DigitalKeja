<?php


namespace Innox\Classes\Repository;


use App\DB\Lease\Payment;
use App\DB\Payment\Disburse;
use App\DB\Payment\MpesaTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\DisburseDateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\QueryFilter\LandlordFilter;
use Innox\Classes\QueryFilter\PaymentMethodFilter;
use Innox\Classes\QueryFilter\UserFilter;

class DisburseRepository
{
    public function store(Request $request)
    {
        return Disburse::create([
            'landlord_id' => $request['landlord_id'],
            'user_id' => auth()->id(),
            'amount' => $request['amount'],
            'payment_method' => $request['payment_method'],
            'reference_number' => $request['reference_number'],
            'disburse_at' => Carbon::parse($request['disburse_at']),
        ]);
    }

    public function filter()
    {
        return app(Pipeline::class)
            ->send(Disburse::query())
            ->through([
                IdFilter::class,
                PaymentMethodFilter::class,
                DateBetweenFilter::class,
                DisburseDateBetweenFilter::class,
                LandlordFilter::class,
                UserFilter::class
            ])
            ->thenReturn()
            ->get();
    }

}

