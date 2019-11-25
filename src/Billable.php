<?php

namespace SamuelNitsche\LaravelPayrexx;

use Payrexx\Models\Request\Gateway;

trait Billable
{
    public function charge($amount): Payment
    {
        $gateway = new Gateway;

        $gateway->setAmount($amount);
        $gateway->setVatRate(7.70);
        $gateway->setCurrency('CHF');

        $payrexxPayment = app('payrexx')->create($gateway);

        $payment = Payment::create([
            'user_id' => $this->id,
            'payrexx_id' => $payrexxPayment->getId(),
            'status' => $payrexxPayment->getStatus(),
            'amount' => $payrexxPayment->getAmount(),
        ]);

        return $payment;
    }
}
