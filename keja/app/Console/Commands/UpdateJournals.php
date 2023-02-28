<?php

namespace App\Console\Commands;

use App\DB\Building\Building;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Innox\Classes\Repository\InvoiceRepository;
use Innox\Classes\Repository\LeaseRepository;
use Modules\Account\Entities\Account;
use Modules\Account\Entities\Repository\AccountRepository;
use Modules\Account\Entities\Repository\JournalRepository;


class UpdateJournals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journal:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Update Journals";

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $journal ;
    private $account ;

    public function __construct()
    {
        parent::__construct();

        $this->journal  =  (new JournalRepository());
        $this->account  =  (new AccountRepository());
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        try {

            DB::beginTransaction();

            $rentAmount = 0;
            $commissionFee = 0;
            $landlordFee = 0;
            foreach (Building::all( ) as $building)
            {

                $rentAmount += $building->expectedRent();
                $commissionFee += $building->manageCommission();
                $landlordFee += $building->landlordFee();


            }




            $this->rentAccount($rentAmount);

            $this->landlordAccount($landlordFee);
            $this->commissionAccount($commissionFee);
            DB::commit();

        }catch (\Exception $exception)
        {

            DB::rollBack();

            dd($exception);
        }

    }

    /* expected money on the bank at the start of the month */


    private function landlordAccount($amount)
    {

        $landlordAccount = $this->account->findByCode('L010104');

        $this->journal->create([
            'account_id' => $landlordAccount->id,
            'debit' => 0,
            'credit' =>   ( round($amount, PHP_ROUND_HALF_EVEN)),
            'payment_id' => null,
            'narration' => "Credit LandlordFunds account by the excepted rent"
        ]);
    }

    /* expected money on the bank at the start of the month */


    private function commissionAccount($amount)
    {

        $bankAccount = $this->account->findByCode('Y0101');

        $this->journal->create([
            'account_id' => $bankAccount->id,
            'debit' => 0,
            'credit' =>  ( round($amount, PHP_ROUND_HALF_EVEN)),
            'payment_id' => null,
            'narration' => "Credit Commission account by the excepted rent"
        ]);
    }
    /* expected money on the rent at the start of the month */


    private function rentAccount($amount)
    {

        $rentAccount = $this->account->findByCode('A010106');

        $this->journal->create([
            'account_id' => $rentAccount->id,
            'debit' =>  ceil( round($amount, PHP_ROUND_HALF_EVEN)),
            'credit' =>  0,
            'payment_id' => null,
            'narration' => "Debit Rent account by the excepted rent"
        ]);
    }
}
