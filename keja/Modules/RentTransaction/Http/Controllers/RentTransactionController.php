<?php

namespace Modules\RentTransaction\Http\Controllers;

use App\DB\Landlord\Landlord;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Innox \Classes\Repository\RentTransactionRepository;
use Modules\RentTransaction\Entities\LandlordTransaction;

class RentTransactionController extends Controller
{
    private $transactions ;

    public function __construct()
    {
        $this->transactions = new RentTransactionRepository;
    }

    /**
     * Display a listing of the resource.
     * @param Landlord $landlord
     * @return Response
     */
    public function index(Landlord $landlord, Request $request)
    {
        return view('renttransaction::index')
            ->with([
                'landlord'  => $landlord,
                'transactions'  => $this->transactions->all($request)
            ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {

        return view('renttransaction::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param Landlord $landlord
     * @return void
     */
    public function store(Request $request , Landlord $landlord )
    {
        $this->validate($request , [
            'amount'  => 'required|array',
            'type'    => 'required|array',
            'month'   => 'required',
            'reason'  => 'required|array',
        ]);
        return $this->transactions
            ->store($request , $landlord);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('renttransaction::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('renttransaction::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
