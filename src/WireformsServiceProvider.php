<?php

namespace Sashalenz\Wireforms;

use Livewire\Livewire;
use Sashalenz\Wireforms\Components\Fields\NestedSetSelect;
use Sashalenz\Wireforms\Components\Fields\Select;
use Sashalenz\Wireforms\Components\Fields\Text;
use Sashalenz\Wireforms\Components\Fields\Textarea;
use Sashalenz\Wireforms\Components\Fields\WireSelect;
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
            Text::class,
            Textarea::class,
            Select::class,
            WireSelect::class,
            NestedSetSelect::class,
        ]);

        Livewire::component('wireforms.livewire.wire-select', \Sashalenz\Wireforms\Livewire\WireSelect::class);
        Livewire::component('wireforms.livewire.nested-set-select', \Sashalenz\Wireforms\Livewire\NestedSetSelect::class);
    }
}
