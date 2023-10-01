<?php

namespace Tests;

class Feature2TestCase extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filament-content-components.namespace', 'Tests\Fixtures\Components');
        $app['config']->set('filament-content-components.path', 'tests/Fixtures/Components');
        $app['config']->set('filament-content-components.components', []);
    }
}