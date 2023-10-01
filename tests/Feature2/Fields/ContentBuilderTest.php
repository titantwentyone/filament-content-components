<?php
/** This uses a different base test case in order to provide different set up for environment **/

it('will automatically detect components from the service container', function() {

    $this->assertEquals(8, count(app('components')));

    $page = new class extends \Filament\Pages\Page {};
    $container = new \Filament\Forms\ComponentContainer(new $page());

    $builder = \Titantwentyone\FilamentContentComponents\Fields\ContentBuilder::make('builder')->container($container);

    $this->assertEquals(8, count($builder->getChildComponents()));

})
->covers(\Titantwentyone\FilamentContentComponents\Fields\ContentBuilder::class);