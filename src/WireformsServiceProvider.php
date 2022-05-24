<?php

namespace Sashalenz\Wireforms;

use Livewire\Livewire;
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
            \Sashalenz\Wireforms\Components\Fields\Text::class,
            \Sashalenz\Wireforms\Components\Fields\Textarea::class,
            \Sashalenz\Wireforms\Components\Fields\Select::class,
            \Sashalenz\Wireforms\Components\Fields\WireSelect::class,
            \Sashalenz\Wireforms\Components\Fields\NestedSetSelect::class,
            \Sashalenz\Wireforms\Components\Fields\DateTime::class,
            \Sashalenz\Wireforms\Components\Fields\Boolean::class,
            \Sashalenz\Wireforms\Components\Fields\Phone::class,
            \Sashalenz\Wireforms\Components\Fields\Money::class
        ]);

        Livewire::component(
            'wireforms.livewire.wire-select',
            \Sashalenz\Wireforms\Livewire\WireSelect::class
        );

        Livewire::component(
            'wireforms.livewire.nested-set-select',
            \Sashalenz\Wireforms\Livewire\NestedSetSelect::class
        );
    }
}
