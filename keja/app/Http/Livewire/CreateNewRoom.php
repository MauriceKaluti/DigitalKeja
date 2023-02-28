<?php

namespace App\Http\Livewire;

use Innox\Classes\Repository\BuildingRepository;
use Livewire\Component;

class CreateNewRoom extends Component
{
    private $filter;


    public $buildingId;
    public $pricings;


    public function __construct($id)
    {
        parent::__construct($id);


        $this->filter =  new BuildingRepository();

    }


    public function getBuildingDetails()
    {
       return [
           'id'  => 9
       ];

    }

    public function render()
    {
        if (request()->has('building_id'))
        {
            request()->request->add(['id' =>  request('building_id')]);
        }
        request()->request->add(['active' =>  true]);

        $buildings = $this->filter->filter(['active' => true]);

        return view('livewire.create-new-room')->with([
            'buildings'   => $buildings
        ]);
    }
}
