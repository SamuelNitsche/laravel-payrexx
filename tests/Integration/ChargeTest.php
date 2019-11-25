<?php

namespace SamuelNitsche\LaravelPayrexx\Tests\Integration;

class ChargeTest extends IntegrationTestCase
{
    /** @test */
    function it_can_create_one_off_charges()
    {
        $user = $this->createUser();

        $payment = $user->charge(500);

        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'payrexx_id' => $payment->payrexx_id,
            'status' => 'waiting',
            'amount' => 500,
        ]);
    }
}
