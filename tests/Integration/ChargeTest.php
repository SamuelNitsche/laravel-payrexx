<?php

namespace SamuelNitsche\LaravelPayrexx\Tests\Integration;

class ChargeTest extends IntegrationTestCase
{
    /** @test */
    public function it_can_create_one_off_charges()
    {
        $user = $this->createUser();

        $response = $user->charge(500);

        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'payrexx_id' => $response->payrexx_id,
            'status' => 'waiting',
            'amount' => 500,
        ]);
        $this->assertEquals(500, $response->rawAmount());
        $this->assertEquals('CHF 5.00', $response->amount());
    }
}
