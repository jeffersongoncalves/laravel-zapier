<?php

namespace JeffersonGoncalves\Zapier;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ZapierServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-zapier')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Zapier::class);
    }
}
