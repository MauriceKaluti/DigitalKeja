<?php

namespace App\Http\Controllers\Landlord;

use App\DataTables\LandlordDataTable;
use App\DB\Landlord\Landlord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Innox\Classes\Handlers\PaymentReport;
use Innox\Classes\Handlers\SmsHandler;
use Innox\Classes\Repository\LandlordRepository;
use Innox\Classes\Repository\PaymentRepository;

class LandlordController extends Controller
{
    private $landlord;

    public function __construct()
    {
        $this->landlord = new LandlordRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (! auth()->user()->can('browse_landlords'))
        {
            accessDenied();
            return  back();

        }
        if ($request->has('landlord'))
        {
            $request->request->add(['id' => $request['landlord']]);
        }


        if ($request->ajax())
        {
            return  (new LandlordDataTable())->all($request);
        }


        return  view('landlords.browse');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (! auth()->user()->can('add_landlords'))
        {
            accessDenied();
            return  back();

        }
        return  view('landlords.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('add_landlords'))
        {
            accessDenied();
            return  back();

        }

        $this->validate($request , [
            'name' => 'required',
            'email' => [
                'nullable',
                Rule::unique('landlords','email')
            ],
            'id_no' => [
                'required',
                Rule::unique('landlords','id_no')
            ],
            'phone_number' => [
                'required',
                Rule::unique('landlords', 'phone_number')
            ],
            'account_name' => [
                'required',
            ],
            'account_number' => 'required',
            'bank' => 'required',
            'address' => 'required',
            'commission_type' => 'required',
            'commission_value' => 'required|numeric',
        ]);

        return  $this->landlord->store($request);

    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Landlord $landlord
     * @return Response
     */
    public function show(Request $request , Landlord $landlord)
    {
        if (! auth()->user()->can('read_landlords'))
        {
            accessDenied();
            return  back();

        }
        $payments = collect();

        if (isset($request['start_date']) && isset($request['end_date']))
        {
            $allPayments = (new PaymentRepository())
                ->filter();


            $payments = (new PaymentReport())
                ->setLandlordId($landlord->id)
                ->setPayments($allPayments)
                ->landlordPayments();

        }




        return  view('landlords.read')->with([
            'landlord'   => $landlord->load('buildings'),
            'payments'   => $payments,
            'tenants'   => collect($landlord->tenants())
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Landlord $landlord)
    {
        if (! auth()->user()->can('edit_landlords'))
        {
            accessDenied();
            return  back();

        }
        return  view('landlords.edit')->with([
            'landlord'   => $landlord
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Landlord $landlord)
    {
        if (! auth()->user()->can('edit_landlords'))
        {
            accessDenied();
            return  back();

        }


        $this->validate($request , [
            'name' => 'required',
            'email' => [
                'nullable',
                'email',
                Rule::unique('landlords','email')->ignore($landlord->id)
            ],
            'phone_number' => [
                'required',
                Rule::unique('landlords', 'phone_number')->ignore($landlord->id)
            ],
            'account_name' => [
                'required',
            ],
            'account_number' => 'required',
            'bank' => 'required',
            'address' => 'required',
        ]);

       $this->landlord->update($request , $landlord);

        flash('successfully created a new landlord')->success()->important();

        return  redirect()
            ->route('landlord_browse')
            ->send();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Landlord $landlord)
    {

        if (! auth()->user()->can('delete_landlords'))
        {
            accessDenied();
            return  back();

        }
        $this->landlord->delete($landlord);

        flash('successfully removed the landlord record')
            ->success()
            ->important();

        return  redirect()
            ->route('landlord_browse')
            ->send();

    }
}
