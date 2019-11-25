<?php

namespace SamuelNitsche\LaravelPayrexx\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use SamuelNitsche\LaravelPayrexx\Payment;

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
