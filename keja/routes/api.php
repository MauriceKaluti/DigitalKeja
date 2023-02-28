<?php

use App\DB\Lease\Invoice;
use App\DB\Lease\Payment;
use App\DB\Tenant;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'payment'], function () {
   Route::get('/register', function () {
       $mpesa = new \Innox\Classes\Handlers\InnoxMpesa();
       $token =  (new  \Innox\Classes\Handlers\InnoxMpesa())->generateLiveToken();
       $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
       $curl = curl_init();
       curl_setopt($curl, CURLOPT_URL, $url);
       curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token)); //setting custom header
       $curl_post_data = array(
           //Fill in the request parameters with valid values
           'ShortCode' => "164034",
           'ResponseType' => 'Completed',
           'ConfirmationURL' =>  url('api/payment/confirmation?key=164034'),
           'ValidationURL' =>  url('api/payment/validation?key=164034')
       );
       $data_string = json_encode($curl_post_data);
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($curl, CURLOPT_POST, true);
       curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
       $curl_response = curl_exec($curl);
       print_r($curl_response);
       echo $curl_response;

   });

   Route::any('/confirmation', 'MpesaPaymentController@confirmation');

   Route::post('/validation',function (Request $request) {

           //Return a success response to m-pesa
           $response = array(
               'ResultCode' => 0,
               'ResultDesc' => 'Success'
           );
           echo json_encode($response);

           //Get input stream data and log it in a file
           $payload = file_get_contents('php://input');
           $file = 'validation_log.txt'; //Please make sure that this file exists and is writable
           $fh = fopen($file, 'a');
           fwrite($fh, "\n====".date("d-m-Y H:i:s")."====\n");
           fwrite($fh, $payload."\n");
           fclose($fh);
       $mpesa = new Mpesa();
       $mpesa->finishTransaction();

   });


   Route::get('/simulate', function () {
      $mpesa = new Mpesa();
       $ShortCode = "601528";
       $CommandID = "CustomerPayBillOnline";
       $Amount = \request('amount') ? \request('amount') : 300;
       $Msisdn = "254708374149";
       $BillRefNumber = \request('account_no');

       return $mpesa->c2b($ShortCode, $CommandID, $Amount, $Msisdn, $BillRefNumber );


   });
});


Route::get('/test', function (){

    $leases = \App\DB\Lease\Lease::where('is_active', 1)->get();

    foreach ($leases->unique('tenant_id') as $lease) {


        if (! isset($lease->room->building->id))
        {
            $lease->delete();
        }

        if (! isset($lease->tenant->id))
        {
            $lease->delete();
        }

    }


    foreach (\App\DB\Building\Building::all() as $building) {


        if (! isset($building->landlord->id))
        {
            $building->delete();
        }
    }

    dd('conr');

});
