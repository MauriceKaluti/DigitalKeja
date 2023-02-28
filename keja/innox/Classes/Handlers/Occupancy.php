<?php


namespace Innox\Classes\Handlers;


use Carbon\Carbon;
use Innox\Classes\Repository\BuildingRepository;
use Innox\Classes\Repository\InvoiceRepository;
use Innox\Classes\Repository\LeaseRepository;
use Innox\Classes\Repository\TenantRepository;

class Occupancy
{
    private $startDate;
    private $endDate;

    private  $leases;
    private  $buildings;

    /**
     * @param mixed $endDate
     * @return Occupancy
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;

    }

    /**
     * @param mixed $startDate
     * @return Occupancy
     */

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    private function getDates()
    {
        return request()
            ->request
            ->add([
                'start_date'  => Carbon::parse($this->startDate),
                'end_date'     => Carbon::parse($this->endDate)
            ]);


    }
    public function getLeases(){

        $this->startDate = null;
        $this->endDate = null;
        request()->request->remove('start_date');
        request()->request->remove('end_date');

        $leases = (new LeaseRepository())
            ->all();



        return $leases;
    }

    public function buildings()
    {
        $this->startDate = null;
        $this->endDate = null;
        request()->request->remove('start_date');
        request()->request->remove('end_date');
        $building = (new BuildingRepository())
            ->filter();
        return $building;

    }

    public function units()
    {
        $rooms = collect();
        request()->request->remove('start_date');
        request()->request->remove('end_date');

        foreach ($this->buildings() as $building) {

            $rooms->push($building->rooms);
        }
        return $rooms;

    }


}
