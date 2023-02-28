<?php


namespace Innox\Classes\Repository;


use App\DB\Building\Building;
use App\DB\Building\Room;
use App\DB\Building\RoomUtility;
use App\DB\Meta;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Innox\Classes\QueryFilter\ActiveFilter;
use Innox\Classes\QueryFilter\BuildingFilter;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\QueryFilter\LandlordFilter;
use Innox\Classes\QueryFilter\VacantFilter;
use Innox\Contracts\ShouldFilter;

class RoomRepository implements ShouldFilter
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
           DateBetweenFilter::class,
           VacantFilter::class,
           BuildingFilter::class,
       ];


       return  app(Pipeline::class)
           ->send(Room::query())
           ->through($filter)
           ->thenReturn()
           ->get();
    }

    public function createRoom(Request $request)
    {
        $room = new Room();


        $room->rent = 0;
        $room->building_id = $request['building_id'];
        $room->deposit = 0;
        $room->deposit_period = 1;
        $room->room_number = $request['room_number'];
        $room->bedrooms = 0;
        $room->save();

        $meta = Meta::create([
            'key'  => 'room_type',
            'value' => $request['room_type']
        ]);

        $room->saveMeta($meta);

        $this->updateRoomUtilities($room , $request);

    }
    public function updateRoomUtilities(Room $room , Request $request)
    {
        // save the utility bills here

        if ($request->has('rent'))
        {
            foreach ($request['rent'] as $roomType =>  $utilities) {
                foreach ($utilities as $utility => $amount) {

                    RoomUtility::updateOrCreate([
                        'room_id' => $room->id,
                        'room_type'  => $roomType,
                        'utility_type'  => "rent",
                        'utility'  => $utility,
                    ],[
                        'room_id' => $room->id,
                        'room_type'  => $roomType,
                        'utility_type'  => "rent",
                        'utility'  => $utility,
                        'amount' => $amount
                    ]);
                }

            }
        }
        if ($request->has('deposit'))
        {
            foreach ($request['deposit'] as $roomType =>  $utilities) {
                foreach ($utilities as $utility => $amount) {

                    RoomUtility::updateOrCreate([
                        'room_id' => $room->id,
                        'room_type'  => $roomType,
                        'utility_type'  => "deposit",
                        'utility'  => $utility,
                    ],[
                        'room_id' => $room->id,
                        'room_type'  => $roomType,
                        'utility_type'  => "deposit",
                        'utility'  => $utility,
                        'amount' => $amount
                    ]);
                }

            }
        }


        //save Room Type
        if ($room->getMeta('room_type', false))
        {
            $room->metable()->delete();
        }
        $meta = Meta::create([
            'key'  => 'room_type',
            'value' => $request['room_type']
        ]);
        $room->saveMeta($meta);


        //save Dynamic Utilities

        if ($request->has('is_dynamic'))
        {
            foreach ($request['is_dynamic'] as $bill)
            {

                if ($room->getMeta('is_dynamic_'.$bill, false) == $bill)
                {
                    $room->metable()->delete();
                }
                $meta = Meta::create([
                    'key'  => "is_dynamic_{$bill}",
                    'value' => true
                ]);
                $room->saveMeta($meta);
            }

        }

    }

    public function updateRoom(Request $request , $id)
    {
        $room = Room::find($id);

        $room->building_id = $request['building_id'];
        $room->room_number = isset($request['room_number']) ? $request['room_number'] : $room->room_number;
        $room->deposit_period = $request['deposit_period'];
        $room->save();

        return $room;

    }

    public function activate(Room $room)
    {
        $room->is_vacant = true;
        $room->save();
       return $room;

    }
    public function delete(Room $room)
    {
        return $room->delete();
    }
}
