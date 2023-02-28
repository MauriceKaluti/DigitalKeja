<?php


namespace Innox\Classes\Handlers;


use Carbon\Carbon;
use Innox\Classes\Repository\InvoiceRepository;
use Innox\Classes\Repository\TenantRepository;

class ExpectedRent
{
    private $startDate;
    private $endDate;

    private  $invoices;

    /**
     * @param mixed $endDate
     * @return ExpectedRent
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;

    }

    /**
     * @param mixed $startDate
     * @return ExpectedRent
     */

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }
    public function getInvoices(){
        request()
            ->request
            ->add([
                'start_date'  => Carbon::parse($this->startDate),
                'end_date'     => Carbon::parse($this->endDate)
            ]);

        $invoices = (new InvoiceRepository())
            ->filter();

        $this->invoices = $invoices;
        return $this;
    }
    public function getExpected()
    {
        // tenant->getExpectedRent()
        // tenant->getTheBalance()

        $expectedRent = 0;


        foreach($this->invoices as $invoice)
        {
            $expectedRent += $invoice->invoiceItems->sum('amount');

        }

        return $expectedRent;
    }

    public function unPaidRents()
    {
        $unPaid = 0;


        foreach($this->invoices as $invoice)
        {

            if ($invoice->status == 'un paid')
            {
                $unPaid += $invoice->invoiceItems->sum('amount');
            }

        }
        return $unPaid;

    }
    public function collectedRent()
    {
        $paid = 0;

        foreach($this->invoices as $invoice)
        {
            foreach ($invoice->payments as $payment)
            {
                $paid += $payment->amount;
            }

        }
        return $paid;

    }


}
