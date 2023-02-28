<?php

namespace App\Http\Controllers\Report;

use App\DB\Lease\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Innox\Classes\Repository\MpesaRepository;
use Innox\Classes\Repository\PaymentRepository;

class ReportsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('browse_reports')){

            accessDenied();
            return back();
        }

        return view('reports.browse');
    }

    public function payment(Request $request)
    {

        if (!auth()->user()->can('payment_reports')){

            accessDenied();
            return back();
        }

        $where = [];

        if (! \request()->has('start_date') && ! $request->has('end_date'))
        {
            $request->request->add([
                'start_date'  => Carbon::now()->startOfDay(),
                'end_date'    => Carbon::now()->endOfDay()
            ]);
        }
        if (! auth()->user()->can('view-all_reports')){

            $request->request->add(['user_id', auth()->id()]);
        }

        $payments = (new PaymentRepository())->filter();

        return view('reports.payment.browse')->with([
            'payments'  => $payments
        ]);

    }
    public function mpesaPayment(Request $request)
    {

        if (!auth()->user()->can('payment_reports')){

            accessDenied();
            return back();
        }

        $payments = (new MpesaRepository())->filter();


        return view('reports.payment.mpesa.browse')->with([
            'payments'  => $payments
        ]);

    }
}
