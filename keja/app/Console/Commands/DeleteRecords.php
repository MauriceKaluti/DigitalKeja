<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $leases = \App\DB\Lease\Lease::where('is_active', 1)->get();

        foreach ($leases->unique('tenant_id') as $lease) {

            if (! isset($lease->room->building->id)) {
                $lease->delete();

            }

            if (! isset($lease->tenant->id))
            {
                $lease->delete();
            }

        }

        foreach (\App\DB\Building\Building::all() as $building) {

            if (! isset($building->landlord->id))
            {
                $building->delete();
            }
        }

    }
}
