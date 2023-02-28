<?php

namespace App\Http\Controllers\Tenant;

use App\DataTables\TenantDataTable;
use App\DB\Building\Room;
use App\DB\Lease\Invoice;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Innox\Classes\Repository\BuildingRepository;
use Innox\Classes\Repository\RoomRepository;
use Innox\Classes\Repository\LeaseRepository;
use Innox\Classes\Repository\NextOfKinRepository;
use Innox\Classes\Repository\PaymentRepository;
use Innox\Classes\Repository\TenantRepository;
use Modules\Account\Entities\Account;

class TenantController extends Controller
{
    private $tenant;

    private  $kin;

    public function __construct()
    {
        $this->tenant = new TenantRepository();
        $this->kin = new NextOfKinRepository();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (! auth()->user()->can('browse_tenant'))
        {
            accessDenied();
            return  back();

        }

        if (\request()->ajax())
        {
            return  (new TenantDataTable())->all(\request());
        }

        return  view('tenant.browse');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (! auth()->user()->can('add_tenant'))
        {
            accessDenied();
            return  back();

        }

       $buildings = (new RoomRepository())->toRent();

       $buildings = Room::query()
            ->with('building')
            ->withoutGlobalScopes()
            ->where('is_vacant', true)
            ->get()
            ->groupBy(function ($q){
                return  $q->building->name  ;
            });

        $rooms = [];


        foreach ($buildings as $index => $building)
        {
            foreach ($building as $room)
            {

                $rooms[$index][] =  ([
                    'id' => $room->id,
                    'room_number' => $room->room_number,
                    'is_vacant' => $room->is_vacant

                ]);
            }
        }

        return  view('tenant.create')->with([
           'buildings'  =>  $rooms,
            'tenant'     => (new Tenant())
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

        if (! auth()->user()->can('add_tenant'))
        {
            accessDenied();
            return  back();

        }

        $this->validate($request ,[
            'name'  => 'required',
            'phone_number'  => ['required', Rule::unique('tenants', 'phone_number')],
            'email'  =>  ['nullable' , Rule::unique('tenants', 'email')],
            'address'  =>  ['nullable'],
            'lease_agreement'  =>  ['nullable'],
            'id_no'  =>  ['required', Rule::unique('tenants', 'id_no')],
            'room_id' => 'required',
           // 'kin_name' => 'required',
           // 'kin_phone_number' => 'required',
           // 'kin_relation' => 'required',
        ], [
          //  'building_id.required' => 'Building Is Required',
            'room_id.required' => 'Unit Is Required',
           // 'kin_name.required' => 'Next of kin name Is Required',
           // 'kin_phone_number.required' => 'Next of kin phone number Required',
           // 'kin_relation.required' => 'Next of kin relation Is Required',
            ]);

      $file = $request->lease_agreement;

         // dd($file); die();


         if ( !empty($file) ) {  
                $file_extension = $file->getClientOriginalExtension();
                $file_name = rand(111, 9999) . '.' . $file_extension;
                $file->move('agreements/',$file_name);
         }

         $request['lease_agreement'] = $file_name;
 
        $tenant = $this->tenant->create($request);
        //$kin = $this->kin->create($request);
      // $this->kin->attachKinable($tenant , $kin);


        (new LeaseRepository())->store($request['room_id'], $tenant->id);


        flash()->success('successfully  created a new tenant')->important();
        return  redirect()
            ->route('tenant_browse')
            ->send();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tenant $tenant)
    {
        if (! auth()->user()->can('read_tenant'))
        {
            accessDenied();
            return  back();

        }

        return  view('tenant.read')
            ->with([
                'tenant' =>$tenant
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tenant $tenant)
    {

        if (! auth()->user()->can('edit_tenant'))
        {
            accessDenied();
            return  back();

        }

        $buildings = (new BuildingRepository())->filter();
        return  view('tenant.create')->with([
            'buildings'  => $buildings,
            'tenant' => $tenant
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tenant $tenant)
    {
        if (! auth()->user()->can('edit_tenant'))
        {
            accessDenied();
            return  back();

        }

        $this->validate($request ,[
            'name'  => 'required',
            'phone_number'  => ['required', Rule::unique('tenants', 'phone_number')->ignore($tenant->id)],
            'email'  =>  ['nullable', Rule::unique('tenants', 'email')->ignore($tenant->id)],
            'address'  =>  ['nullable'],
            'lease_agreement'  =>  ['nullable'],
            'id_no'  =>  ['required', Rule::unique('tenants', 'id_no')->ignore($tenant->id)],
            'kin_name' => 'required',
            'kin_phone_number' => 'required',
            'kin_relation' => 'required',
        ], [
            'building.required' => 'Building Is Required',
            'kin_name.required' => 'Next of kin name Is Required',
            'kin_phone_number.required' => 'Next of kin phone number Required',
            'kin_relation.required' => 'Next of kin relation Is Required',
        ]);

           $file = $request->lease_agreement;

         // dd($file); die();


         if ( !empty($file) ) {  
                $file_extension = $file->getClientOriginalExtension();
                $file_name = rand(111, 9999) . '.' . $file_extension;
                $file->move('agreements/',$file_name);
         }

         $request['lease_agreement'] = $file_name;
        
        $tenant = $this->tenant->update($tenant , $request);


        flash()->success('successfully  created a new tenant')->important();
        return  redirect()
            ->route('tenant_view', ['tenant'  => $tenant->id])
            ->send();

    }


        public function updateAgreement(Request $request, $id)
    {
        if (! auth()->user()->can('edit_tenant'))
        {
            accessDenied();
            return  back();

        }

         $tenant = Tenant::find($id);
         
         $input = $request->all();

         $file = $request->lease_agreement;



         if ( !empty($file) ) {  
                $file_extension = $file->getClientOriginalExtension();
                $file_name = rand(111, 9999) . '.' . $file_extension;
                $file->move('agreements/',$file_name);
         }

         // dd($file_name); die();

         $input['lease_agreement'] = $file_name;
        
        // $tenant->update($input);
    
         Tenant::where( 'id', '=', $id)->update(['lease_agreement' => $file_name]);

        return back()->with('success','Agreement Updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tenant $tenant)
    {

        if (! auth()->user()->can('delete_tenant'))
        {
            accessDenied();
            return  back();

        }

        $this->tenant->delete($tenant);

        flash()->success('successfully deleted tenant')->important();
        return  redirect()
            ->route('tenant_browse')
            ->send();


    }


    public function unlease(Tenant $tenant)
    {


        if(isset($tenant->lease))
        {

            $this->tenant->release($tenant);

        }


        return redirect()->route('tenant_view', ['tenant' => $tenant->id]);

    }


    public function pay(Tenant $tenant , Tenant\TenantAccount $account)
    {


        return view('tenant.account.pay')
            ->with([
                'tenant' => $tenant,
                'account' => $account,
                'amount' => \request('amount')
            ]);
    }
    public function editRent(Tenant $tenant, Tenant\TenantAccount $account)
    {



        return view('tenant.account.edit')
            ->with([
                'tenant' => $tenant,
                'account' => $account
            ]);
    }


    public function storePay(Tenant $tenant, Tenant\TenantAccount $account , Request $request )
    {
        $this->validate($request ,[
            'reference_code' => 'required',
            'deposit_at' => 'required',
            'month' => 'required',
        ]);

        $request->request->add([
            'deposit_date' =>($request['deposit_at'])
        ]);

       // dd($request->all());

        try {
            foreach (\request('amount') as $index => $amount)
            {

                $request->request->add(['amount' => $amount , 'item' => $index]);

                (new PaymentRepository())->store($request->all() , $tenant , $account);

           }
            flash()->message('successfully deleted tenant')->success();

            return redirect()->route('tenant_view', ['tenant' => $tenant->id]);
        }
        catch (\Exception $exception)
        {
            flash()->message($exception->getMessage())->warning();

            return redirect()->back();
        }
    }

    public function updateRent(Tenant $tenant , Tenant\TenantAccount $account)
    {

        foreach (\request('amount') as $index => $amount) {

            Tenant\TenantAccountItem::where('id', $index)->update([
                'amount' => $amount
            ]);
        }

        flash()->message('successfully updated tenant')->success();

        return redirect()->route('tenant_view', ['tenant' => $tenant->id]);
    }
}
