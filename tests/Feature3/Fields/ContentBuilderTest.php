<?php

it('will allow components when defined in config', function () {

    $page = new class extends \Filament\Pages\Page {};
    $container = new \Filament\Forms\ComponentContainer(new $page());

    $builder = \Titantwentyone\FilamentContentComponents\Fields\ContentBuilder::make('builder')->container($container);

    $this->assertEquals(count($builder->getChildComponents()), 2);
})
->covers(\Titantwentyone\FilamentContentComponents\Fields\ContentBuilder::class);
