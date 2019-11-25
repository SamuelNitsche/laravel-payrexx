<?php

namespace SamuelNitsche\LaravelPayrexx\Tests\Unit;

use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use SamuelNitsche\LaravelPayrexx\Payment;
use SamuelNitsche\LaravelPayrexx\Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user()
    {
        $user = $this->createUser();
        $payment = new Payment;
        $payment->user_id = $user->id;

        $this->assertInstanceOf(User::class, $payment->user);
    }

    /** @test */
    public function it_has_an_amount()
    {
        $payment = new Payment;
        $payment->amount = 500;

        $this->assertEquals(500, $payment->rawAmount());
    }

    /** @test */
    public function it_can_format_the_amount_human_readable()
    {
        $this->markTestIncomplete('Charset issues');

        $payment = new Payment;
        $payment->amount = 500;

        $this->assertContains('CHF 5.00', $payment->amount());
    }

    /** @test */
    public function it_can_return_its_confirmed_status()
    {
        $payment = new Payment;
        $payment->status = 'confirmed';

        $this->assertTrue($payment->isConfirmed());
    }

    /** @test */
    public function it_can_return_its_cancelled_status()
    {
        $payment = new Payment;
        $payment->status = 'cancelled';

        $this->assertTrue($payment->isCancelled());
    }

    /** @test */
    public function it_can_return_its_waiting_status()
    {
        $payment = new Payment;
        $payment->status = 'waiting';

        $this->assertTrue($payment->isWaiting());
    }

    /** @test */
    public function it_can_return_its_declined_status()
    {
        $payment = new Payment;
        $payment->status = 'declined';

        $this->assertTrue($payment->isDeclined());
    }

    /** @test */
    public function it_can_return_its_refunded_status()
    {
        $payment = new Payment;
        $payment->status = 'refunded';

        $this->assertTrue($payment->isRefunded());
    }
}
