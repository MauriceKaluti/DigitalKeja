<?php

namespace App\Http\Controllers\Building;

use App\DB\Building\BuildingPricing;
use App\DB\Building\Building;
use App\DB\Building\Room;
use App\DB\Landlord\Landlord;
use App\DB\Meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Innox\Classes\Repository\BuildingRepository;

class BuildingController extends Controller
{
    private $buildingRespository;

    public function __construct()
    {
        $this->buildingRespository = new BuildingRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! auth()->user()->can('browse_building'))
        {
            accessDenied();
            return  back();

        }

        $buildings =$this->buildingRespository->filter();

        return  view('building.browse')
            ->with([
                'buildings'  => $buildings->load('rooms.lease.tenant','landlord')
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if (! auth()->user()->can('add_building'))
        {
            accessDenied();
            return  back();

        }

        $landlords = Landlord::active()->get();

        if ($request['landlord'])
        {
            $landlords = Landlord::where('id', $request['landlord'])->get();
        }

        return  view('building.create')
            ->with([
                'landlords'  => $landlords
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

        if (! auth()->user()->can('add_building'))
        {
            accessDenied();
            return  back();
        }

        $this->validate($request , [
            'name' => 'required',
            'landlord_id' => 'required',
            'location' => 'required',
            'commission_rate' => 'required',

        ],[
            'landlord_id.required'  => 'Landlord is required'
        ]);

        return  $this->buildingRespository->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Building $building)
    {
        if (!auth()->user()->can('read_building')) {
            accessDenied();

        }
        return view('building.read')
            ->with([
                'building'  => $building->load('landlord','rooms')
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Building $building)
    {
        if (! auth()->user()->can('edit_building'))
        {
            accessDenied();
            return  back();
        }
        $landlords = Landlord::active()->get();
        return  view('building.edit')
            ->with([
                'building' => $building,
                'landlords' => $landlords
            ]);
    }


    public function update(Request $request, Building $building)
    {
        if (!auth()->user()->can('edit_building'))
        {
            accessDenied();
            return  back();
        }

        $this->buildingRespository->update($request , $building);

        flash('successfully updated building')->success()->important();

        return  redirect()->route('building_read', ['building' => $building->id])->send();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Building $building)
    {
        if (! auth()->user()->can('delete_building'))
        {
            accessDenied();
            return  back();
        }
        $landlord = $building->landlord->id;

        $this->buildingRespository->delete($building);
        return redirect()
            ->route('landlord_read', ['landlord'  => $landlord]);
    }


    public function settings(Building $building)
    {
        return view('building.setting')
            ->with([
                'building'  => $building
            ]);
    }

    public function storeSettings(Building $building , Request $request)
    {
        foreach ($request['rent'] as $roomType =>  $utilities) {
            foreach ($utilities as $utility => $amount) {

                    BuildingPricing::updateOrCreate([
                        'building_id' => $building->id,
                        'unit_type'  => $roomType,
                        'utility'  => $utility,
                        'utility_type'  => "rent",
                    ],[
                       'building_id' => $building->id,
                        'unit_type'  => $roomType,
                        'utility'  => $utility,
                        'utility_type'  => "rent",
                        'amount'   => $amount
                    ]);
            }

        }
        foreach ($request['deposit'] as $roomType =>  $utilities) {
            foreach ($utilities as $utility => $amount) {

                    BuildingPricing::updateOrCreate([
                        'building_id' => $building->id,
                        'unit_type'  => $roomType,
                        'utility_type'  => "deposit",
                        'utility'  => $utility,
                    ],[
                       'building_id' => $building->id,
                        'unit_type'  => $roomType,
                        'utility'  => $utility,
                        'utility_type'  => "deposit",
                        'amount'   => $amount
                    ]);
            }

        }

        flash('updated the price settings')
            ->success()
            ->important();
        return back();
    }

}
