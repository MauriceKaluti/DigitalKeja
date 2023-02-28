<?php

namespace App\Http\Controllers\Building;

use App\DB\Building\Building;
use App\DB\Building\Room;
use App\DB\Building\RoomUtility;
use App\DB\Meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Innox\Classes\Repository\BuildingRepository;
use Innox\Classes\Repository\RoomRepository;

class RoomController extends Controller
{
    private  $room;
    private $building;

    public function __construct()
    {
        $this->room = new RoomRepository();
        $this->building = new BuildingRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ( ! auth()->user()->can('browse_rooms'))
        {
            accessDenied();
            return  back();
        }

        $rooms = $this->room->filter();

        return  view('building.room.browse')->with([
            'rooms'  => $rooms
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ( ! auth()->user()->can('add_rooms'))
        {
            accessDenied();
            return  back();
        }

        if (request()->has('building_id'))
        {
            request()->request->add(['id' =>  request('building_id')]);
        }
        request()->request->add(['active' =>  true]);

        $buildings = $this->building->filter();

        unset($request['id']);


        return  view('building.room.create')->with([
            'buildings'   => $buildings
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
        if ( ! auth()->user()->can('add_rooms'))
        {
            accessDenied();
            return  back();
        }

        $this->validate($request ,[
            'building_id'  => 'required',
            'room_number'   => [
                'required',
                Rule::unique('rooms','room_number')->where('building_id', $request['building_id'])
            ],
        ]);

        $this->room->createRoom($request);

        flash('created a new room')
            ->success()
            ->important();

        return  back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        if ( ! auth()->user()->can('read_rooms'))
        {
            accessDenied();
            return  back();
        }

        return  view('building.room.read')
            ->with([
                'room' => $room
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        if ( ! auth()->user()->can('edit_rooms'))
        {
            accessDenied();
            return  back();
        }

        return  view('building.room.edit')
            ->with([
                'room'  => $room,
                'buildings' => $this->building->filter()
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        if ( ! auth()->user()->can('edit_rooms'))
        {
            accessDenied();
            return  back();
        }
        $room = $this->room->updateRoom($request, $room->id);

        $this->room->updateRoomUtilities($room , $request);

        return  redirect()
            ->route('landlord_read' ,['landlord' => $room->building->landlord->id])
            ->send();
    }
    public function activate(Request $request, Room $room)
    {
        if ( ! auth()->user()->can('edit_rooms'))
        {
            accessDenied();
            return  back();
        }
        $this->room->activate($room);



        return  redirect()
            ->route('landlord_read' ,['landlord' => $room->building->landlord->id])
            ->send();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        if ( ! auth()->user()->can('delete_rooms'))
        {
            accessDenied();
            return  back();
        }
        $building = $room->building;

        $this->room->delete($room);

        flash('successfully deleted a room')
            ->success()
            ->important();

        return  redirect()
            ->route('building_read' ,['building' => $building->id ])
            ->send();
    }



    public function pricing(Request $request)
    {

        return view('building.room.pricing')
            ->with([
                'roomsIds'   => $request['room_id']
            ]);
    }

    public function updatePricing(Request $request)
    {
        $room = new Room();

        foreach ($request['room_id'] as $key => $roomId) {

            $room = Room::where('id', $roomId)->first();

            (new RoomRepository())->updateRoomUtilities($room , $request);

        }


        flash('successfully updated the room pricing')->success()->important();
        return  redirect()
            ->route('landlord_read' ,['landlord' => $room->building->landlord->id])
            ->send();
    }
}
