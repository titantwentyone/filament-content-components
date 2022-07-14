<?php

namespace Titantwentyone\FilamentContentComponents;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentContentComponentsServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-content-components')
            ->hasConfigFile();
            //->hasViews();
    }
}