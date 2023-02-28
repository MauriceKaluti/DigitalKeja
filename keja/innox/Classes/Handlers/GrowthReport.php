<?php


namespace Innox\Classes\Handlers;


use Innox\Classes\Repository\BuildingRepository;
use Innox\Classes\Repository\DisburseRepository;
use Innox\Classes\Repository\LandlordRepository;
use Innox\Classes\Repository\PaymentRepository;

class GrowthReport
{

    private function payment()
    {
        request()
            ->request
            ->add([
                'start_date'  => now()->startOfYear(),
                'end_date'   => now()->endOfYear()
            ]);

        return  (new PaymentRepository())
            ->filter()
            ->groupBy(function ($income) {

                return $income->created_at->format('Y-F');
            });
    }

    private function landlordDisbursement()
    {
        request()
            ->request
            ->add([
                'start_date'  => now()->startOfYear(),
                'end_date'   => now()->endOfYear()
            ]);

        return  (new DisburseRepository())
            ->filter()
            ->groupBy(function ($income) {

                return $income->created_at->format('Y-F');
            });
    }

    public function income()
    {
      $income = [];

        foreach ($this->payment() as $index => $payment)
        {
            foreach ($this->landlordDisbursement() as $key => $disbursement)
            {

                if ($key === $index)
                {
                    $income[$index] = ['amount' => $payment->sum('amount') - $disbursement->sum('amount')];
                   //$income->push($data);
                }

            }
        }


        return $income;

    }
    public function landlord()
    {
        request()
            ->request
            ->add([
                'start_date'  => now()->startOfYear(),
                'end_date'   => now()->endOfYear()
            ]);
        return  (new LandlordRepository())
            ->filter()
            ->groupBy(function ($landlord) {

                return $landlord->created_at->format('Y-F');
            });

    }
    public function building()
    {

        request()
            ->request
            ->add([
                'start_date'  => now()->startOfYear(),
                'end_date'   => now()->endOfYear()
            ]);
        return  (new BuildingRepository())
            ->filter(['active'  => true])
            ->groupBy(function ($building) {
                return $building->created_at->format('Y-F');
            });

    }

}
