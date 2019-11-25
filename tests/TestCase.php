<?php

namespace SamuelNitsche\LaravelPayrexx\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use SamuelNitsche\LaravelPayrexx\PayrexxServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getEnvironmentSetUp($app)
    {

    }

    protected function getPackageProviders($app)
    {
        return [
            PayrexxServiceProvider::class,
        ];
    }
}
