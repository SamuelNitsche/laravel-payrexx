<?php

namespace SamuelNitsche\LaravelPayrexx\Tests\Fixtures;

use Illuminate\Foundation\Auth\User as Authenticatable;
use SamuelNitsche\LaravelPayrexx\Billable;

class User extends Authenticatable
{
    use Billable;
}
