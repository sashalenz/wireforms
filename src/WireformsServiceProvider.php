<?php

namespace Sashalenz\Wireforms;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WireformsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('wireforms')
            ->hasViews()
            ->hasTranslations();
    }
}
