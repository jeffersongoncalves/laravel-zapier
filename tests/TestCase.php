<?php

namespace JeffersonGoncalves\Zapier\Tests;

use JeffersonGoncalves\Zapier\ZapierServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ZapierServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('zapier.api_key', 'test-api-key');
        $app['config']->set('zapier.base_url', 'https://api.zapier.com/v1');
        $app['config']->set('zapier.hooks.new-lead', 'https://hooks.zapier.com/hooks/catch/123/abc');
    }
}
