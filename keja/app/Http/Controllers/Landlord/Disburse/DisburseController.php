<?php

namespace App\Http\Controllers\Landlord\Disburse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Innox\Classes\Repository\DisburseRepository;
use Innox\Classes\Repository\LandlordRepository;

class DisburseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! auth()->user()->can('disburse_landlord_payments'))
        {
            accessDenied();
            return  back();
        }

        $request->request->add(['active'  => true]);

        $landlords = (new LandlordRepository())
            ->filter();

        return  view('payments.disburse.index')
            ->with([
                'landlords' => $landlords
            ]);
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
        $this->validate($request , [
            'landlord_id'  => 'required',
            'amount'      => 'required',
            'payment_method'  => 'required',
            'reference_number'   => 'required',
            'disburse_at'  => 'required'
        ]);

        (new DisburseRepository())
            ->store($request);
        flash("successfully created a disbursement record")
            ->success()
            ->important();
        return  redirect()
            ->route('landlord_read',['landlord' => $request['landlord_id']])
            ->send();
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
