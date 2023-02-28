<?php


namespace Innox\Classes\Repository;


use App\DB\Tenant;
use Illuminate\Routing\Pipeline;
use Illuminate\Http\Request;
use Innox\Classes\QueryFilter\ActiveFilter;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Contracts\ShouldFilter;
use File; 

class TenantRepository implements ShouldFilter
{

    public function filter(array $args = [])
    {
         return app(Pipeline::class)
             ->send(Tenant::query())
             ->through([
                 IdFilter::class,
                 ActiveFilter::class,
                 DateBetweenFilter::class,
             ])
             ->thenReturn()
             ->latest('id')
             ->with('lease.room.building')
             ->get();
    }

    public function create(Request $request)
    {

        return  Tenant::create([
            'name'  => $request['name'],
            'phone_number'  => $request['phone_number'],
            'email'   => $request['email'],
            'lease_agreement'   => $request['lease_agreement'],
            'address'   => $request['address'],
            'id_no'  => $request['id_no']
        ]);

    }
    public function update(Tenant $tenant , Request $request)
    {


        $tenant =  Tenant::updateOrCreate([
            'id' => $tenant->id
        ],[
            'name'  => $request['name'],
            'phone_number'  => $request['phone_number'],
            'email'   => $request['email'],
            'address'   => $request['address'],
            'lease_agreement'   => $request['lease_agreement'],
            'id_no'  => $request['id_no'],
            'is_active'  => $request['status']
        ]);

        if (isset($request['kin_id']) && ! is_null($request['kin_id']))
        {
            if(isset($tenant->kinable)) {
                (new NextOfKinRepository())->update($request['kin_id'], $request);
            }
        }
        else{
            $kin =  (new NextOfKinRepository())->create($request);
            (new NextOfKinRepository())->attachKinable($tenant , $kin);
        }


        return $tenant;

    }

    public function delete(Tenant $tenant)
    {
        return $tenant->delete();
    }

    
    public function release(Tenant $tenant)
    {
        $room = $tenant->lease->room;
        $lease = $tenant->lease;
        $lease->is_active = false;
        $lease->save();

        $room->is_vacant = true;
        $room->save();

        $tenant->is_active = true;
        $tenant->save();
        flash()->success('successfully detached tenant from Room: ' . $room->room_number .' '. $room->building->name)->important();

    }



    public function occupants()
    {
        \request()->request->add(['active' => true]);
        return app(Pipeline::class)
            ->send(Tenant::query())
            ->through([
                IdFilter::class,
                ActiveFilter::class,
                DateBetweenFilter::class,
            ])
            ->thenReturn()
            ->get();
    }



}
