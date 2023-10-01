<?php

//getEnvironmentSetUp(function($app) {
//    $app['config']->set('filament-content-components.namespace', '\Tests\Fixtures\Components');
//    $app['config']->set('filament-content-components.path', __DIR__.'/Fixtures/Components');
//});

use Tests\Fixtures\Components\LivewireComponents\WithComplexLivewireComponent;
use Tests\Fixtures\Components\StringComponents\StringContentComponent;

//function components_defined_in_service_container($app)
//{
//    $app['config']->set('filament-content-components.namespace', 'Tests\Fixtures\Components');
//    $app['config']->set('filament-content-components.path', 'tests/Fixtures/Components');
//    $app['config']->set('filament-content-components.components', []);
//}

//function componentsDefinedInConfig($app)
//{
//    $app['config']->set('filament-content-components.namespace', '');
//    $app['config']->set('filament-content-components.path', '');
//
//    $app['config']->set('filament-content-components.components', [
//        WithComplexLivewireComponent::class,
//        StringContentComponent::class
//    ]);
//}



it('will allow components when defined on component', function () {

    $page = new class extends \Filament\Pages\Page {};
    $container = new \Filament\Forms\ComponentContainer(new $page());

    $builder = \Titantwentyone\FilamentContentComponents\Fields\ContentBuilder::make('builder')
        ->components([
            \Tests\Fixtures\Components\LivewireComponents\WithSimpleLivewireComponent::class
        ])
        ->container($container);

    $this->assertEquals(1, count($builder->getChildComponents()));
})
->covers(\Titantwentyone\FilamentContentComponents\Fields\ContentBuilder::class);