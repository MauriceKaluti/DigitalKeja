<?php

namespace App\Http\Controllers\Setting;

use App\DB\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view('setting.browse');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        $data['company_tag_line'] = $request->has('company_tag_line') ?  $request['company_tag_line'] : \setting('company_tag_line');
        $data['company_email'] = $request->has('company_email') ?  $request['company_email'] : \setting('company_email');
        $data['company_name'] = $request->has('company_name') ?  $request['company_name'] : \setting('company_name');
        $data['company_tel'] = $request->has('company_tel') ?  $request['company_tel'] : \setting('company_tel');
        $data['advanta_partner_id'] = $request->has('advanta_partner_id') ?  $request['advanta_partner_id'] : \setting('advanta_partner_id');
        $data['advanta_api_key'] = $request->has('advanta_api_key') ?  $request['advanta_api_key'] : \setting('advanta_api_key');
        $data['advanta_short_code'] = $request->has('advanta_short_code') ?  $request['advanta_short_code'] : \setting('advanta_short_code');
        $data['company_address'] = $request->has('company_address') ?  $request['company_address'] : \setting('company_address');
        $data['payment_reminder_sms'] = $request->has('payment_reminder_sms') ?  $request['payment_reminder_sms'] : \setting('payment_reminder_sms');
        $data['payment_notification_sms'] = $request->has('payment_notification_sms') ?  $request['payment_notification_sms'] : \setting('payment_notification_sms');
        $data['payment_overdue_sms'] = $request->has('payment_overdue_sms') ?  $request['payment_overdue_sms'] : \setting('payment_overdue_sms');
        $data['company_currency'] = $request->has('company_currency') ?  $request['company_currency'] : \setting('company_currency');
        $data['company_skin'] = $request->has('company_skin') ?  $request['company_skin'] : \setting('company_skin');
        $data['allow_cash_payment'] =  isset($request['allow_cash_payment']) ? true : false;

       if ($request->hasFile('company_logo'))
       {
           if (Storage::disk('local')->exists('logo/logo.png')){
               Storage::disk('local')->delete('logo/logo.png');
           }
           $data['company_logo'] = $request->file('company_logo')->storeAs('logo','logo.png','public');
       }

        Setting::add($data);

        flash('Business settings updated successful')->success()->important();

        return  back();
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
