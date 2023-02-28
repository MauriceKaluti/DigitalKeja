<?php

namespace Modules\Account\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\Entities\ChartOfAccount;

class AccountDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $charts = [
            ['name'  => 'Asset Account' ,  'glcode' =>  'A01', 'description'  =>  "Asset Account"],
            ['name'  => 'Liability Account' , 'glcode' =>  'L01','description'  => "Liability Account"],
            ['name'  => 'Expense Account' , 'glcode' =>  'X01','description'  => "Expense Account"],
            ['name'  => 'Equity Account' ,'glcode' =>  'C01', 'description'  => "Equity Account"],
            ['name'  => 'Income Account' , 'glcode' =>  'Y01', 'description'  => "Income Account"],
        ];

        collect($charts)->each(function ($chart, $index) {

            $chart = ChartOfAccount::create([
                'name'  => $chart['name'],
                'glcode'   => $chart['code'],
                'description'  => $chart['description'],
            ]);
        });

    }
}
