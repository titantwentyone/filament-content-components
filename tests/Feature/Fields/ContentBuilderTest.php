<?php

use Tests\Fixtures\Components\LivewireComponents\WithComplexLivewireComponent;
use Tests\Fixtures\Components\StringComponents\StringContentComponent;

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