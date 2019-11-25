<?php

namespace SamuelNitsche\LaravelPayrexx\Events;

use Illuminate\Queue\SerializesModels;
use SamuelNitsche\LaravelPayrexx\Payment;
use Illuminate\Foundation\Events\Dispatchable;

class PaymentReceived
{
    use Dispatchable, SerializesModels;

    public $payment;
    public $payload;

    public function __construct(Payment $payment, array $payload)
    {
        $this->payment = $payment;
        $this->payload = $payload;
    }
}