<?php


namespace Innox\Classes\Repository;


use App\DB\Building\Building;
use App\DB\Building\Room;
use App\DB\Meta;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Innox\Classes\QueryFilter\ActiveFilter;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\QueryFilter\LandlordFilter;
use Innox\Contracts\ShouldFilter;

class BuildingRepository implements ShouldFilter
{


    public function toRent()
    {
        return Room::query()
            ->with('building')
            ->withoutGlobalScopes()
            ->where('is_vacant', true)
            ->get()
            ->groupBy(function ($q){
                return  $q->building->name;
            });

    }

    public function filter(array $args = [])
    {
       $filter = [
           IdFilter::class,
           LandlordFilter::class,
           DateBetweenFilter::class,
       ];
       if (isset($args['active']))
       {
           $filter[] = ActiveFilter::class;
       }

       return  app(Pipeline::class)
           ->send(Building::query())
           ->through($filter)
           ->thenReturn()
           ->get();
    }



    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $building = Building::create([
                'name'         => $request['name'],
                'landlord_id'  => $request['landlord_id'],
                'total_rooms'  => $request['no_of_units'],
                'location'     => $request['location'],
                'commission_rate'     => $request['commission_rate'],
            ]);

            for ($units = 1 ; $units <= $request['no_of_units'] ; $units++){

                $building->rooms()->create([
                    'room_number'   => "{$units}"
                ]);
            }

     
            flash('successfully added a new building')->success()->important();

            DB::commit();
            return  redirect()->route('landlord_read', ['landlord' => $building->landlord->id])->send();
        }
        catch (\Exception $exception)
        {
            DB::rollBack();

            flash($exception->getMessage())->error()->important();

            return  back()
                ->withInput()
                ->withErrors($exception->getMessage());

        }
    }

    public function update(Request $request, Building $building)
    {
        $building->name = $request['name'];
        $building->landlord_id = $request['landlord_id'];
        $building->location = $request['location'];
        $building->save();

        if ($request->has('rent'))
        {
            foreach ($request['rent'] as $key => $item)
            {
                Room::create([
                    'building_id' => $building->id,
                    'room_number' => $request['room_no'][$key],
                    'rent'        => $request['rent'][$key],
                    'deposit'     => $request['deposit'][$key]
                ]);
            }
        }

        if ( $building->getMeta('commission_type', false))
        {
            $commissionValueMeta = $building->metable()->where('key','commission_value')->first();
            $commissionTypeMeta = $building->metable()->where('key','commission_type')->first();

            $building->deleteMeta($commissionTypeMeta);
            $building->deleteMeta($commissionValueMeta);

        }
        else
        {
            $meta = Meta::create([
                'key'  => 'commission_type',
                'value'  => $request['commission_type']
            ]);

            $building->saveMeta($meta);

            $meta = Meta::create([
                'key'  => 'commission_value',
                'value'  => $request['commission_value']
            ]);

            $building->saveMeta($meta);
        }
    }

    public function delete(Building $building)
    {
        $building->delete();
    }
}
