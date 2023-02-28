<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class UpdatePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update application permissions';

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
        $endPoints = [
            'browse',
            'read',
            'edit',
            'add',
            'delete',
        ];
        $modules = [
            'dashboard' => ['browse'],
            'user' => [ 'browse','read','edit','add','delete','deactivate_user'],
            'role' => $endPoints, // array_push($endPoints,'deactivate_role'),
            'landlords' =>   [ 'browse','read','edit','add','delete','transactions'],
            'building' => [
                'browse',
                'read',
                'edit',
                'add',
                'setting',
                'delete'
            ],
            'rooms' => $endPoints,
            'tenant' => $endPoints,
            'lease_room' =>[
                'browse',
                'read',
                'edit',
                'add',
                'unlease',
                'delete',
            ],
            'invoices' => $endPoints,
            'reports' => ['browse','view-all','payment','landlord','delete',],
            'setting' => ['browse','add','edit', 'delete',],
            'payments' => ['browse', 'disburse_landlord','expenses', 'mpesa'],
            'chart' => ['view', 'create','update','read']
        ];

        foreach ($modules as  $module => $permissions)
        {
            foreach ($permissions as $permission) {

                $this->info('updating new permissions ' . $permission.'_'. $module);
                Permission::updateOrCreate([
                    'name' => $permission.'_'.$module,
                    'module' => $module
                ],[
                    'name' => $permission.'_'.$module,
                    'module' => $module
                ]);

            }
        }
        $this->info('finished');
    }
}
