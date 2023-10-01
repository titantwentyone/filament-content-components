<?php

namespace Tests;

use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Tests\Fixtures\Http\Livewire\ComplexLivewireComponent;
use Tests\Fixtures\Http\Livewire\SimpleLivewireComponent;

class TestingServiceProvider extends \Spatie\LaravelPackageTools\PackageServiceProvider
{
    public function getId(): string
    {
        return 'filament-content-component-resources';
    }

    public function configurePackage(Package $package): void
    {
        $package->name($this->getId());
    }

    public function bootingPackage() : void
    {
        Livewire::component('simple-livewire-component', SimpleLivewireComponent::class);
        Livewire::component('complex-livewire-component', ComplexLivewireComponent::class);

        //TestableLivewire::mixin(new TestableLivewireMixin());

        Testable::mixin(new TestableLivewireMixin());
    }
}