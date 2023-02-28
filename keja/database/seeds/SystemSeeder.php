<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRole();
        $this->setupSetting();
    }

    private function createRole()
    {
       Artisan::call('permission:update');
        $role = Role::create([
            'name' => 'Admin'
        ]);

        foreach (Permission::all() as $permission) {
            $role->givePermissionTo($permission);

        }
        // Create User

        $user = User::create([
            'name' => \Faker\Factory::create()->name,
            'email' => 'admin@admin.com',
            'phone_number'  => \Faker\Factory::create()->phoneNumber,
            'password' => Hash::make('password'),
        ]);
        $user->assignRole($role->name);
    }

    private function setupSetting()
    {
        $setting = [
            'company_name' => 'Innox Rentals Sacco',
            'company_address'  => 'PO BOX 78 , NAKURU',
            'company_tel'  => '254714686511',
            'company_email'  => 'info@digitalmarketingkenya.com',

        ];

        \App\DB\Setting::add($setting);

    }
}
