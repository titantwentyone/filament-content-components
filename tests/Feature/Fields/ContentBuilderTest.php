<?php

//getEnvironmentSetUp(function($app) {
//    $app['config']->set('filament-content-components.namespace', '\Tests\Fixtures\Components');
//    $app['config']->set('filament-content-components.path', __DIR__.'/Fixtures/Components');
//});

it('will automatically detect components', function() {

    $this->assertEquals(count(app('components')), 7);

    $page = new class extends \Filament\Pages\Page {};
    $container = new \Filament\Forms\ComponentContainer(new $page());

    $builder = \Titantwentyone\FilamentContentComponents\Fields\ContentBuilder::make('builder')->container($container);

    $this->assertEquals(count($builder->getChildComponents()), 7);

});