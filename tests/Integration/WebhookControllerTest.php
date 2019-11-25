<?php

namespace SamuelNitsche\LaravelPayrexx\Tests\Integration;

use Illuminate\Support\Facades\Event;
use SamuelNitsche\LaravelPayrexx\Payment;
use SamuelNitsche\LaravelPayrexx\Tests\TestCase;
use SamuelNitsche\LaravelPayrexx\Events\WebhookHandled;
use SamuelNitsche\LaravelPayrexx\Events\WebhookReceived;
use SamuelNitsche\LaravelPayrexx\Events\PaymentReceived;

class WebhookControllerTest extends TestCase
{
    /** @test */
    public function it_can_handle_confirmed_payments()
    {
        Event::fake();

        $payment = Payment::create([
            'user_id' => $user = $this->createUser()->id,
            'payrexx_id' => 1,
            'status' => 'waiting',
            'amount' => 500,
        ]);

        $this->assertTrue($payment->isWaiting());

        $response = $this->postJson('/payrexx/webhook', [
            'transaction' => [
                'id' => $payment->payrexx_id,
                'status' => 'confirmed',
            ],
        ]);

        Event::assertDispatched(WebhookReceived::class);
        Event::assertDispatched(WebhookHandled::class);
        Event::assertDispatched(PaymentReceived::class);
    }
}