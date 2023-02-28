<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkSmsRequest;
use Illuminate\Http\Request;
use Innox\Classes\Handlers\AdvantaMessageHandler;
use Innox\Classes\Repository\TenantRepository;
use DB;
class SmsController extends Controller
{

    public function create()
    {

        return  view('communications.sms.create');
    }

    public function store(BulkSmsRequest $request)
    {
        if( isset( $request['all_tenants']))
        {
            foreach ((new TenantRepository())->occupants() as $occupant)
            {
                $effective =  date('m/Y');

                $effective_date =   $effective."/1";

                $deadline =  date('m/Y');

                $deadline_date =   $deadline."/7";
                
                $tid = $occupant->id;

                $lease = DB::table("leases")->where( 'tenant_id', '=', $tid )->count();
                
                $leas = DB::table("leases")->where( 'tenant_id', '=', $tid )->first();                
                   
                      if ($lease == 1)
                        {
                           $roomID = $leas->room_id;
                        }else{
                            $roomID = 1;
                        }
                    

                $utilityRent = 'rent';

                $required_rent = DB::table("room_utilities")->where( 'room_id', $roomID )->where( 'utility_type', $utilityRent )->sum('amount');                            

                (new AdvantaMessageHandler())->send($occupant->phone_number,"Dear ".$occupant->name.", your rent balance as at ".$effective_date. " is Ksh. ".$required_rent. ", Please make payment via M-Pesa Paybill 164034 and A/c ". $occupant->id_no." by ". $deadline_date. " to avoid penalties" . $request['message']);
            }
        }

        if ($request->has('phone'))
        {
            (new AdvantaMessageHandler())->send(\request('phone'),$request['message']);
        }

        flash('message sent successfully')->success()->important();


        return redirect()
            ->back();
    }


}
