<?php

namespace Tests;

use Filament\PluginServiceProvider;
use Livewire\Livewire;
use Tests\Fixtures\Filament\Resources\PageResource;
use Tests\Fixtures\Http\Livewire\ComplexLivewireComponent;
use Tests\Fixtures\Http\Livewire\SimpleLivewireComponent;

class ResourceServiceProvider extends PluginServiceProvider
{
    public static string $name = 'resources';

    protected function getResources(): array
    {
        return [
            PageResource::class
        ];
    }

    public function bootingPackage() : void
    {
        Livewire::component('simple-livewire-component', SimpleLivewireComponent::class);
        Livewire::component('complex-livewire-component', ComplexLivewireComponent::class);
    }
}