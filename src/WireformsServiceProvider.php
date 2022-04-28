<?php

namespace Sashalenz\Wireforms;

use Sashalenz\Wireforms\Components\Fields\Text;
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

    public function packageBooted(): void
    {
        $this->loadViewComponentsAs('wireforms', [
            Text::class
        ]);
    }
}
