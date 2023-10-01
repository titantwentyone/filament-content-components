<?php

namespace Tests;

use Tests\Fixtures\Components\LivewireComponents\WithComplexLivewireComponent;
use Tests\Fixtures\Components\StringComponents\StringContentComponent;

class Feature3TestCase extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filament-content-components.namespace', '');
        $app['config']->set('filament-content-components.path', '');

        $app['config']->set('filament-content-components.components', [
            WithComplexLivewireComponent::class,
            StringContentComponent::class
        ]);
    }
}