<?php

namespace App\Console\Commands;

use App\DB\Building\Room;
use App\DB\Tenant\TenantAccount;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Innox\Classes\Repository\InvoiceRepository;
use Innox\Classes\Repository\LeaseRepository;

class GenarateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:rent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate invoice every month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        request()->request->add(['is_active'  => true]);
        request()->setUserResolver(function (){
            if (! Auth::check())
            {
                return Auth::login(User::first());
            }
        });

        $leases = (new LeaseRepository())->all();

        foreach ($leases as $lease)
        {

           if ($lease->room instanceof Room && isset($lease->tenant->id))
           {

               $leaseRepository =  (new LeaseRepository());

               try {
                   DB::beginTransaction();
                   $tenantAccount = $leaseRepository->storeTenantAccount($lease);

                  $leaseRepository->storeTenantAccountItems($lease->room, $tenantAccount);

                 // dd($tenantAccount->tenantAccountItems);
                   DB::commit();
               }catch (\Exception $exception)
               {
                  //dd($exception);
                   DB::rollBack();
               }
           }

        }
    }
}
