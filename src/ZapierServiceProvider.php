<?php

namespace Jeffersongoncalves\Zapier;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ZapierServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-zapier')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}
