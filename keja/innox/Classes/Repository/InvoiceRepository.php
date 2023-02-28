<?php
namespace Innox\Classes\Repository;

use App\DB\Building\Room;
use App\DB\Lease\Invoice;
use App\DB\Tenant\TenantAccount;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\QueryFilter\InvoiceUnPaidStatus;
use Innox\Classes\QueryFilter\PaymentStatusFilter;
use Innox\Contracts\ShouldFilter;

class InvoiceRepository implements ShouldFilter
{

    public function filter(array $args = [])
    {
         return app(Pipeline::class)
             ->send(TenantAccount::query())
             ->through([
                 IdFilter::class,
                // PaymentStatusFilter::class,
                 DateBetweenFilter::class,
                // InvoiceUnPaidStatus::class
             ])
             ->thenReturn()
            // ->tenantId()
             ->with('room','tenant')
             ->get();
    }

    public function store($tenantId , $leaseId)
    {
        return Invoice::create([
            'lease_id' => $leaseId,
            'tenant_id' => $leaseId,
            'status'   => 'un paid',
            'deposit'  => 0,
            'rent'     => 0
        ]);

    }
    public function storeRentItems(Room $room , Invoice $invoice)
    {
        foreach ($room->utilities->where('utility_type','rent') as $roomUtility) {
            $invoice->invoiceItems()->create([
            'utility'  =>  $roomUtility->utility,
            'amount'  =>  $roomUtility->amount,
                ]);
        }
    }
    public function storeDepositItems(Room $room , Invoice $invoice)
    {
        if (! $room->utilities->where('utility_type','deposit')->count())
        {

            foreach ( utilitiesBills() as $utilitiesBill => $roomUtility) {
                $invoice->invoiceItems()->create([
                    'utility'  =>  $utilitiesBill,
                    'amount'  => 0 ,
                ]);
            }
        }
        else{
            foreach ($room->utilities->where('utility_type','deposit') as $roomUtility) {
                $invoice->invoiceItems()->create([
                    'utility'  =>  $roomUtility->utility,
                    'amount'  =>  $roomUtility->amount,
                ]);
            }
        }
    }

}
