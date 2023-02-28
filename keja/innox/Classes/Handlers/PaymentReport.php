<?php


namespace Innox\Classes\Handlers;


class PaymentReport
{
    private  $payments;
    private  $landlordId;

    public function landlordPayments()
    {
        $payments = collect();
        foreach ($this->payments as $payment)
        {

            $lease = $payment->lease;

            if (isset($lease->room->building->landlord->id))
            {
                if ($this->landlordId === $lease->room->building->landlord->id )
                {
                    $payments->push($payment);
                }

            }
        }

        return $payments;

    }

    /**
     * @param mixed $payments
     * @return PaymentReport
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;
        return $this;
    }

    /**
     * @param mixed $landlordId
     * @return PaymentReport
     */
    public function setLandlordId($landlordId)
    {
        $this->landlordId = $landlordId;

        return $this;
    }
}
