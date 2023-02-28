<?php

namespace App\Http\Controllers;

use App\DB\Lease\Invoice;
use App\DB\Lease\Payment;
use App\DB\Payment\MpesaTransaction;
use App\DB\Tenant;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Innox\Classes\Repository\MpesaRepository;
use Innox\Classes\Repository\PaymentRepository;
use Modules\Account\Entities\Repository\AccountRepository;
use Modules\Account\Entities\Repository\JournalRepository;

class MpesaPaymentController extends Controller
{
    public function confirmation(Request $request)
    {

            //Return a success response to m-pesa
            $response = array(
                'ResultCode' => 0,
                'ResultDesc' => 'Success'
            );
        echo json_encode($response);


        (new  MpesaRepository())->store($request);

        $tenant = Tenant::where('id_no', $request['BillRefNumber'])->firstOrFail();


        $tenantAccount =  Tenant\TenantAccount::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])
            ->first();

        /*$payload = file_get_contents('php://input');
        $file = 'confirm_log.txt'; //Please make sure that this file exists and is writable
        $fh = fopen($file, 'a');
        fwrite($fh, "\n====".date("d-m-Y H:i:s")."====\n");
        fwrite($fh, $payload."\n");
        fwrite($fh, "Tenant"."\n");
        fwrite($fh, "{$tenant->id}"."\n");
        fwrite($fh, "{$tenant->name}"."\n");
        fwrite($fh, "LEASE"."\n");
        fwrite($fh, "{$lease->id}"."\n");
        fwrite($fh, "INVOICE"."\n");
        fwrite($fh, "INVOICE"."\n");
        fwrite($fh, "{$invoice->id}"."\n");
        fclose($fh);*/


        //$tenant = Tenant::where('id_no', $request['BillRefNumber'])->first();
        //$lease = $tenant->lease;


        $request->request->add([
            'user_id' => User::first()->id,
            'payment_method' => 'Mpesa',
            'reference_code' => $request['TransID'],
            'amount' => $request['TransAmount'],
            'deposit_at' => now()
        ]);

        foreach ($tenantAccount->tenantAccountItems as $item) {
            $amount = floatval($request['TransAmount']);

            $balance = 0;

            if (strtolower($item->item) === 'rent') {
                if ($amount > $item->amount) {

                    $request->request->add([
                        'item' => 'rent',
                        'amount' => $amount - floatval($item->amount)
                    ]);

                    $balance = $amount - floatval($item->amount);

                }
            }

            if (strtolower($item->item === 'water')) {
                if ($balance > $item->amount) {

                    $request->request->add([
                        'item' => 'water',
                        'amount' => $balance - floatval($item->amount)
                    ]);
                    $balance = $balance - floatval($item->amount);
                }

            }

            if (strtolower($item->item === 'security')) {

                if ($balance > $item->amount) {

                    $request->request->add([
                        'item' => 'security',
                        'amount' => $balance - floatval($item->amount)
                    ]);

                    $balance = $balance - floatval($item->amount);
                }

            }
            if (strtolower($item->item === 'garbage collections')) {

                if ($balance > $item->amount) {

                    $request->request->add([
                        'item' => 'garbage collections',
                        'amount' => $balance - floatval($item->amount)
                    ]);

                    $balance = $balance - floatval($item->amount);
                }

            }
            if (strtolower($item->item === 'caretaker')) {

                if ($balance > $item->amount) {

                    $request->request->add([
                        'item' => 'caretaker',
                        'amount' => $balance - floatval($item->amount)
                    ]);

                    $balance = $balance - floatval($item->amount);
                }
                if ($balance > $item->amount) {

                    $request->request->add([
                        'item' => 'rent',
                        'amount' => $balance
                    ]);

                }

            }
            $payment  =   (new PaymentRepository())->store($request->all() , $tenant , $tenantAccount);
            $this->createJournal($payment);
        }




    }


}
