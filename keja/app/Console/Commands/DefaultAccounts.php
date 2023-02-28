<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Account\Entities\Account;
use Modules\Account\Entities\ChartOfAccount;

class DefaultAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chart:account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Default Account';

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
        $charts = ChartOfAccount::all();

        foreach ($charts as $chart) {

            Account::create([
                'chart_id'  => $chart->id,
                'name'      => $chart->name,
                'has_children'  => true,
                'description'  => $chart->description,
                'glcode'  => $chart->glcode
            ]);

        }
    }
}
