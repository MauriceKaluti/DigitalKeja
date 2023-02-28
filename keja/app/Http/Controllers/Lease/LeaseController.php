<?php

namespace App\Http\Controllers\Lease;

use App\DB\Building\Building;
use App\DB\Building\Room;
use App\DB\Lease\Invoice;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Innox\Classes\QueryFilter\ActiveFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\QueryFilter\RoomFilter;
use Innox\Classes\Repository\BuildingRepository;
use Innox\Classes\Repository\ExpensesRepository;
use Innox\Classes\Repository\LeaseRepository;
use Innox\Classes\Repository\TenantRepository;

class LeaseController extends Controller
{
    private  $lease;

    public function __construct()
    {
        $this->lease = new LeaseRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if ( ! auth()->user()->can('browse_lease_room'))
        {
            accessDenied();
            return  back();
        }
        \request()->request->add(['is_active' => true]);

        $leases = $this->lease->all();

        return  view('lease.browse')->with(['leases'  => $leases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if ( ! auth()->user()->can('add_lease_room'))
        {
            accessDenied();
            return  back();
        }


      if ($request->has('room_id'))
        {

           $rrid = $request->has('room_id'); 
    $rum = DB::table("rooms")->where( 'id', '=', $rrid )->first(); 
             
        }



        if ($request->has('tenant_id'))
        {
            $request['id'] = $request['tenant_id'];
        }

        $request->request->add(['active' => true ]);

        $tenants = (new TenantRepository())->filter();

        if (isset($request['id']))
        {
            unset($request['id']);
        }

        unset($request['active']);

        if ($request->has('room_id'))
        {
            $request->request->add(['id' =>  Room::find($request['room_id'])->building->id ]);
        }
        $buildings = (new ExpensesRepository())->filter();

         if (isset($request['id']))
         {
             unset($request['id']);
         }

        return view('lease.create')->with([
            'tenants'    => $tenants,
            'buildings'  => $buildings,
            'rum'  => $rum,
            'room'    => $request->has('room_id') ? Room::active()->where('id',  $request['room_id'])->first() : false,
            'tenant_id'    => $request->has('tenant_id') ? $request['tenant_id'] : false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ( ! auth()->user()->can('add_lease_room'))
        {
            accessDenied();
            return  back();
        }

        $this->validate($request, [
            'building_id'    =>  'required',
            'room_id'        =>  [
                'required',
                Rule::unique('leases')->where('is_active', true),
            ],
            'tenant_id'      =>  'required'
        ],[
            'building_id.required'    =>  'kindly select a building',
            'room_id.required'        =>  'Kindly select a '. trans('general.room').' from the list',
            'tenant_id.required'      =>  'Kindly select a tenant from the list'
        ]);

        try{

            DB::beginTransaction();
            $lease = $this->lease->store($request['room_id'], $request['tenant_id']);
            flash('successfully created a new lease and invoice continue and pay for the invoice')
                ->success()
                ->important();
            DB::commit();
            return redirect()
                ->route('landlord_read', ['landlord' => $lease->room->building->landlord->id])
                ->send();
        }catch (\Exception $exception)
        {
            DB::rollBack();

            flash($exception->getMessage())
                ->error()
                ->important();

            return redirect()
                ->back();

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
    public function destroy(Lease $lease)
    {
        if ( ! auth()->user()->can('delete_lease_room'))
        {
            accessDenied();
            return  back()->setStatusCode('403');
        }

        $this->lease->delete($lease);
         flash('successfully removed lease record')
             ->success()
             ->important();

         return  redirect()
             ->route('landlord_browse');

    }
}
