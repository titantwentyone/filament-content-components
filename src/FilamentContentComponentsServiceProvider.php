<?php

namespace Titantwentyone\FilamentContentComponents;

use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use function League\Uri\parse;

class FilamentContentComponentsServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-content-components')
            ->hasConfigFile();
            //->hasViews();
    }

    public function bootingPackage()
    {
        Blade::directive('parseContentComponent', function($expression) {
            return "<?php echo parseContentComponent({$expression}); ?>";
        });
    }
}