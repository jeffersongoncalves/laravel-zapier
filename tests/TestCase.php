<?php

namespace Jeffersongoncalves\Zapier\Tests;

use Jeffersongoncalves\Zapier\ZapierServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ZapierServiceProvider::class,
        ];
    }
}
