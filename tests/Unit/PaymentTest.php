<?php

namespace SamuelNitsche\LaravelPayrexx\Tests\Unit;

use SamuelNitsche\LaravelPayrexx\Payment;
use SamuelNitsche\LaravelPayrexx\Tests\TestCase;

class PaymentTest extends TestCase
{
    /** @test */
    function it_has_an_amount()
    {
        $payment = new Payment;
        $payment->amount = 500;

        $this->assertEquals(500, $payment->rawAmount());
    }

    /** @test */
    public function it_can_format_the_amount_human_readable()
    {
        $payment = new Payment;
        $payment->amount = 500;

        $this->assertEquals('CHF 5.00', iconv('UTF-8', 'CP437', $payment->amount()));
    }
}
