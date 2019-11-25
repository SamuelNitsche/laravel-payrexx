<?php

namespace SamuelNitsche\LaravelPayrexx\Tests\Integration;

use Illuminate\Database\Eloquent\Model as Eloquent;
use SamuelNitsche\LaravelPayrexx\Tests\Fixtures\User;
use SamuelNitsche\LaravelPayrexx\Tests\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Eloquent::unguard();

        $this->loadLaravelMigrations();

        $this->artisan('migrate')->run();
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function createUser(): User
    {
        return User::create([
            'email' => 'mail@samynitsche.de',
            'name' => 'John Doe',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
    }
}
