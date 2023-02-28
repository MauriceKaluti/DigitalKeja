<?php

namespace App\Http\Controllers\Invoice;

use App\DB\Lease\Invoice;
use App\DB\Lease\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Innox\Classes\Repository\PaymentRepository;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(! auth()->user()->can('browse_payments'))
        {
            accessDenied();
            return  back();
        }
        $payments = (new PaymentRepository())
            ->filter();

        return  view('payments.browse')
            ->with([
                'payments'   => $payments
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function create(Invoice $invoice)
    {
        return  view('invoice.payment.create')
            ->with([
                'invoice'  => $invoice
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\DB\Lease\Invoice $invoice
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request , Invoice $invoice)
    {
        $rules = [
            'amount' => 'required',
            'deposit_at' => 'required',
            'reference_code' => 'required',
            ];

        if (isset($request['payment_method']) && strtolower($request['payment_method']) == 'bank')
        {
            $rules['receipt'] = 'mimes:jpeg,png,pdf';
        }

        $this->validate($request , $rules);



        try{
            if ($invoice->balance() < 1) {

                throw new \Exception("Invoice is fully paid");
            }
            $depositDate = Carbon::parse($request['deposit_at'])->startOfDay();

            if ($depositDate->greaterThan(now()))
            {
                flash('Deposit date cannot be a future date')
                    ->error()
                    ->important();
                return back()
                    ->withInput();

            }

                if($request['amount'] > $invoice->balance() )
                {
                    throw new \Exception("Amount cannot be greater than ". $invoice->balance());
                }

                $paymentRepository = ( new PaymentRepository());
                $paymentRepository->store($request, $invoice);

          flash('successfully updated the invoice')
                ->success()
                ->important();
            return  redirect()
                ->route('invoice_show', ['invoice' => $invoice->id]);
        }
        catch (\Exception $exception)
        {
            flash($exception->getMessage())
                ->error()
                ->important();
            return  back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
