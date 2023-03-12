<?php

namespace Tests\Feature\Fields;

use Filament\Forms\ComponentContainer;
use Filament\Pages\Page;
use Livewire\LivewireServiceProvider;
use Tests\Fixtures\Components\LivewireComponents\WithComplexLivewireComponent;
use Tests\Fixtures\Components\LivewireComponents\WithSimpleLivewireComponent;
use Tests\Fixtures\Components\StringComponents\StringContentComponent;
use Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenGetViewMethod;
use Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenViewProperty;
use Titantwentyone\FilamentContentComponents\Fields\ContentBuilder;
use Titantwentyone\FilamentContentComponents\FilamentContentComponentsServiceProvider;

class ContentBuilderTest extends \Orchestra\Testbench\TestCase
{
    public function defineEnvironment($app)
    {
        $app['config']->set('filament-content-components.namespace', '\\Tests\\Fixtures\\Components');
        $app['config']->set('filament-content-components.path', __DIR__.'/../../Fixtures/Components');
    }

    public function defineComponentsInConfig($app)
    {
        $app['config']->set('filament-content-components.components', [
            WithComplexLivewireComponent::class,
            StringContentComponent::class
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            FilamentContentComponentsServiceProvider::class
        ];
    }

    /**
     * @test
     * @define-env defineEnvironment
     */
    public function it_will_automatically_detect_components()
    {
        $this->assertEquals(count(app('components')), 7);

        $page = new class extends Page{};
        $container = new ComponentContainer(new $page());

        $builder = ContentBuilder::make('builder')->container($container);

        $this->assertEquals(count($builder->getChildComponents()), 7);
    }

    /**
     * @test
     * @define-env defineComponentsInConfig
     */
    public function it_will_only_allow_components_specified_in_config()
    {
        $page = new class extends Page{};
        $container = new ComponentContainer(new $page());

        $builder = ContentBuilder::make('builder')->container($container);

        $this->assertEquals(count($builder->getChildComponents()), 2);
    }

    /**
     * @test
     * @todo possible move to ContentBuilderTest
     */
    public function it_will_allow_setting_specific_components_to_be_used_in_a_builder()
    {
        $page = new class extends Page{};
        $container = new ComponentContainer(new $page());

        $builder = ContentBuilder::make('builder')->container($container)->components([
            WithSimpleLivewireComponent::class,
            ViewContentComponentWithOverriddenViewProperty::class,
            ViewContentComponentWithOverriddenGetViewMethod::class
        ]);

        $this->assertEquals(count($builder->getChildComponents()), 3);
    }
}