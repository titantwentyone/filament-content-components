<?php

namespace Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Livewire\LivewireServiceProvider;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Tests\Fixtures\Models\User;
use Titantwentyone\FilamentContentComponents\FilamentContentComponentsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        //User::factory()->create();
        $this->actingAs(User::factory()->create());
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    protected function getPackageProviders($app): array
    {
        return array_merge(parent::getPackageProviders($app), [
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            ResourceServiceProvider::class,
            FilamentContentComponentsServiceProvider::class
        ]);
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        //change location of view folder
        $app['config']->set('view.paths', array_merge(
//            $app['config']->get('view.paths'),
//            [__DIR__.'/resources/views'],
//            [resource_path('views')],
//            [__DIR__.'/../vendor/filament/filament/resources/views']
        ));

        $app['config']->set('view.paths', array_merge(
            $app['config']->get('view.paths'),
            [__DIR__ . '/resources/views']
        ));

        //$app['config']->set('livewire.class_namespace', 'Tests\\Fixtures\\Http\\Livewire');
        $app['config']->set('livewire.view_path', __DIR__ . '/resources/views/livewire');

        //Specific config for Filament CMS
        $app['config']->set('filament-content-components.namespace', 'Tests\Fixtures\Components');
        $app['config']->set('filament-content-components.path', 'tests/Fixtures/Components');

        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
    }
}