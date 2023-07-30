<?php

namespace Titantwentyone\FilamentContentComponents\Console\Commands;

use Filament\Support\Commands\Concerns\CanManipulateFiles;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderLivewire;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderString;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderView;

class MakeComponentCommand extends Command
{
    protected $signature = 'make:content-component {name} {--type=text}';

    protected $description = 'Creates a Filament Content Component';

    private function package_path($path)
    {
        return __DIR__."/../../../{$path}";
    }

    public function handle(): void
    {
        $component = Str::of($this->argument('name'))->ucfirst();
        $model_fqn = "App\\Components\\$component";
        $type = match($this->option('type')) {
            'string' => CanRenderString::class,
            'view' => CanRenderView::class,
            'livewire' => CanRenderLivewire::class,
            default => CanRenderString::class
        };
        $view = Str::of($component)->lower()->slug();

        $livewire_component = "";

        if($type == CanRenderLivewire::class) {
            $livewire_component = "// Specify the livewire component to be used with this content component
    protected static string \$component = 'livewire-component';";
        }

        $this->writeStub(
            'src/Components/component',
            app_path("Components/{$component}Component.php"),
            [
                'component' => $component.'Component',
                'type' => $type,
                'view' => $view,
                'render_method' => $this->getRenderMethod($type, $view),
                'livewire_component' => $livewire_component
            ]
        );
    }

    private function getRenderMethod($type, $view)
    {
        return match($type) {
            CanRenderString::class => "protected static function renderString(\$data): string
    {
        return \$data['hello'];
    }",
            CanRenderView::class => "// This method may be deleted if \$data is to be passed directly to the view
    protected static function renderView(\$data)
    {
        return view('$view', [
            'message' => \$data['hello']
        ]);
    }",
            CanRenderLivewire::class => "// This method may be deleted if \$data is to be passed directly to the livewire component
    protected static function mountArguments(\$data) : array
    {
        return array_merge(\$data, [
            'additional_data' => 'something'
        ]);
    }",
            default => ""
        };
    }

    private function writeStub(string $stub, string $targetPath, array $replacements)
    {
        $filesystem = app(Filesystem::class);

        $stubPath = $this->package_path("stubs/{$stub}.stub");

        if(!$filesystem->exists($stubPath)) {
            throw new \Exception("Stub does not exist - {$stubPath}");
        }

        $stub = Str::of($filesystem->get($stubPath));

        foreach ($replacements as $key => $replacement) {
            $stub = $stub->replace("{{ {$key} }}", $replacement);
        }

        //clean up
        //$stub = Str::of($filesystem->get($stubPath));
        $stub = preg_replace(
            "/{{ ([[:alnum:]]*) }}/",
            "",
            $stub
        );

        if(!$filesystem->exists(app_path('Components')))
        {
            $filesystem->makeDirectory(app_path('Components'));
        }
        //$this->writeFile($targetPath, $stub);
        $filesystem->put($targetPath, $stub);

    }
}
