<?php

namespace App\Http\Livewire;

use App\DB\Building\Building;
use Illuminate\Pipeline\Pipeline;
use Innox\Classes\QueryFilter\BuildingFilter;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\QueryFilter\LandlordFilter;
use Innox\Classes\Repository\RoomRepository;
use Livewire\Component;

class Room extends Component
{
    public function render()
    {

        $rooms = (new RoomRepository())->filter();


        return view('livewire.room')->with([
            'rooms' => $rooms
        ]);
    }
}
