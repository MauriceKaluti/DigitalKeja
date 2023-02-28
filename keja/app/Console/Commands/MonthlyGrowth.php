<?php

namespace App\Console\Commands;

use App\DB\Building\Building;
use App\DB\Landlord\Landlord;
use App\DB\Tenant;
use App\Growth;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MonthlyGrowth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:growth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Growth indicator';

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
        $data = [
            'tenants' => Tenant::count(),
            'landlords' => Landlord::count(),
            'buildings' => Building::count()
            ];
        foreach ($data as $key => $value)
        {
            Growth::create([
                'month' => now()->format('Y-m'),
                'key'   => Str::snake(now()->format('Y-m')).'_'.$key,
                'value' => $value
            ]);
        }

    }
}
