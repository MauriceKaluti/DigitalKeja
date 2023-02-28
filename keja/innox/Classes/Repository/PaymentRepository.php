<?php


namespace Innox\Classes\Repository;


use App\Business\Upload;
use App\DB\Lease\Invoice;
use App\DB\Lease\Payment;
use App\DB\Payment\MpesaTransaction;
use App\DB\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\QueryFilter\InvoiceFilter;
use Innox\Classes\QueryFilter\PaymentMethodFilter;

class PaymentRepository
{

    public function filter()
    {
        return app(Pipeline::class)
            ->send(Payment::query())
            ->through([
                IdFilter::class,
                PaymentMethodFilter::class,
                DateBetweenFilter::class,
                InvoiceFilter::class
            ])
            ->thenReturn()
            ->get();
    }

    public function store(array $request , Tenant $tenant , Tenant\TenantAccount $tenantAccount)
    {

        $payment = Payment::create([
            'amount' => $request['amount'],
            'lease_id' => $tenant->lease->id,
            'tenant_id'  =>  $tenant->id,
            'item'  =>  $request['item'],
            'tenant_account_id'  =>  $tenantAccount->id,
            'payment_method' => $request['payment_method'],
            'reference_code' => $request['reference_code'],
            'deposit_at' => Carbon::parse($request['deposit_date']),
            'user_id' =>  isset($request->user_id) ? $request['user_id'] : \request()->user()->id
        ]);

//        if ($request->hasFile('receipt'))
//        {
//            $path = $request->file('receipt')->store('invoices', 'public');
//
//            $upload = Upload::create([
//                'key'   => "receipt",
//                'url'   => $path
//            ]);
//
//            $payment->saveUpload($upload);
//        }



        return $payment;

    }

}

