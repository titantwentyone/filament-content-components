<?php

namespace Titantwentyone\FilamentContentComponents;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Symfony\Component\Finder\SplFileInfo;
use Titantwentyone\FilamentContentComponents\Console\Commands\MakeComponentCommand;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;
use function League\Uri\parse;

class FilamentContentComponentsServiceProvider extends PackageServiceProvider
{
    public function getId(): string
    {
        return 'filament-content-components';
    }

    public function configurePackage(Package $package): void
    {
        $package->name('filament-content-components')
            ->hasConfigFile()
            ->hasCommands(MakeComponentCommand::class)
            ->hasViews();
    }

    public function bootingPackage()
    {
        Blade::directive('parseContentComponent', function($expression) {
            return "<?php echo parseContentComponent({$expression}); ?>";
        });

        $components = [];

        $this->registerComponents(
            ContentComponent::class,
            $components,
            config('filament-content-components.path') ?: realpath(app_path('Components')),
            config('filament-content-components.namespace') ?: 'App\\Components'
        );

        $this->app->instance('components', $components);
    }

    private function registerComponents(string $baseClass, array &$register, ?string $directory, ?string $namespace): void
    {
        if (blank($directory) || blank($namespace)) {
            return;
        }

        if (Str::of($directory)->startsWith(config('filament.livewire.path'))) {
            return;
        }

        $filesystem = app(Filesystem::class);

        if ((! $filesystem->exists($directory)) && (! Str::of($directory)->contains('*'))) {
            return;
        }

        $namespace = Str::of($namespace);

        $register = array_merge(
            $register,
            collect($filesystem->allFiles($directory))
                ->map(function (SplFileInfo $file) use ($namespace): string {
                    $variableNamespace = $namespace->contains('*') ? str_ireplace(
                        ['\\' . $namespace->before('*'), $namespace->after('*')],
                        ['', ''],
                        Str::of($file->getPath())
                            ->after(base_path())
                            ->replace(['/'], ['\\']),
                    ) : null;

                    if (is_string($variableNamespace)) {
                        $variableNamespace = (string) Str::of($variableNamespace)->before('\\');
                    }

                    return (string) $namespace
                        ->append('\\', $file->getRelativePathname())
                        ->replace('*', $variableNamespace)
                        ->replace(['/', '.php'], ['\\', '']);
                })
                ->filter(fn (string $class): bool => is_subclass_of($class, $baseClass) && (! (new \ReflectionClass($class))->isAbstract()))
                ->all(),
        );
    }
}