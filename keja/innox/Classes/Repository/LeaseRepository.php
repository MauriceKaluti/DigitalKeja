<?php


namespace Innox\Classes\Repository;


use App\DB\Building\Room;
use App\DB\Lease\Invoice;
use App\DB\Lease\Lease;
use App\DB\Tenant\TenantAccount;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Innox\Classes\QueryFilter\ActiveFilter;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\QueryFilter\RoomFilter;
use Innox\Classes\QueryFilter\TenantFilter;

class LeaseRepository
{
    public function store($roomId , $tenantId)
    {
        // validate

        if (Lease::where([
            'room_id'  =>$roomId,
            'tenant_id'   => $tenantId
        ])->count())
        {
            flash('Tenant already allocated the same unit')
                ->error()
                ->important();
            return back()
                ->withInput();
        }
        $lease = Lease::create([
            'room_id'  =>$roomId,
            'tenant_id'   => $tenantId
        ]);
        $room = Room::find($roomId);
        $room->is_vacant = false;
        $room->save();
        $invoiceRepository =  (new InvoiceRepository());
        $invoice =$invoiceRepository->store($tenantId, $lease->id );
        $invoiceRepository->storeDepositItems($room, $invoice);

        return $lease;

    }

    public function all()
    {
        return  app(Pipeline::class)
            ->send(Lease::query())
            ->through([
                IdFilter::class,
                DateBetweenFilter::class,
                TenantFilter::class,
                RoomFilter::class,
                ActiveFilter::class

            ])
            ->thenReturn()
            ->get()
            ->where('tenant_id','!=', null);
    }

    public function update(Lease $lease , Request $request)
    {

    }

    public function delete(Lease $lease)
    {
        // set the room to be active
        if (isset($lease->room->id))
        {
            $room =  $lease->room;
            $room->is_vacant = true;
            $room->save();
        }

       //set tenant to be in active
        if (isset($lease->tenant->id))
        {
            $tenant = $lease->tenant;
            $tenant->is_active = true;
            $tenant->save();
        }

       return  $lease->delete();

    }


    public function storeTenantAccount(Lease $lease)
    {
        return TenantAccount::create([
            'tenant_id'  => $lease->tenant->id,
            'room_id' => $lease->room->id,
            'month' => now()->format('Y-m')
        ]);
    }


    public function storeTenantAccountItems(Room $room, TenantAccount $tenantAccount)
    {

        foreach ($room->utilities->where('utility_type','rent') as $roomUtility) {
            $item = $tenantAccount->tenantAccountItems()->create([
                'item'  =>  $roomUtility->utility,
                'amount'  =>  $roomUtility->amount,
                'tenant_id' => $tenantAccount->tenant->id,
                'is_paid' => false
            ]);

        }
    }

}
