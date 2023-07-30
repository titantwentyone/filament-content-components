<?php

namespace Tests\Feature\Console\Commands;

use Illuminate\Support\Facades\File;
use Nette\Utils\FileSystem;
use Tests\TestCase;

class MakeContentComponentCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_will_create_a_string_content_component()
    {
        $mock = $this->partialMock(\Illuminate\Filesystem\Filesystem::class, function(\Mockery\MockInterface $mock) {
            $mock->shouldReceive('put')
                ->with(app_path("Components/TestComponent.php"), $this->getStringComponentClass())
                ->once();
        });

        app()->bind(Filesystem::class, fn() => $mock);

        $this->artisan('make:content-component Test --type=string');
    }

    /**
     * @test
     */
    public function it_will_create_a_view_content_component()
    {
        $mock = $this->partialMock(\Illuminate\Filesystem\Filesystem::class, function(\Mockery\MockInterface $mock) {
            $mock->shouldReceive('put')
                ->with(app_path("Components/TestComponent.php"), $this->getViewComponentClass())
                ->once();
        });

        app()->bind(Filesystem::class, fn() => $mock);

        $this->artisan('make:content-component Test --type=view');
    }

    /**
     * @test
     */
    public function it_will_create_a_livewire_content_component()
    {
        $mock = $this->partialMock(\Illuminate\Filesystem\Filesystem::class, function(\Mockery\MockInterface $mock) {
            $mock->shouldReceive('put')
                ->with(app_path("Components/TestComponent.php"), $this->getLivewireComponentClass())
                ->once();
        });

        app()->bind(Filesystem::class, fn() => $mock);

        $this->artisan('make:content-component Test --type=livewire');
    }

    private function getStringComponentClass()
    {
        return <<<EOF
<?php

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class TestComponent extends ContentComponent
{
    use Titantwentyone\FilamentContentComponents\Contracts\CanRenderString;

    

    public static function getField(): Block
    {
        return Block::make('test')
            ->schema([
                TextInput::make('hello')
            ]);
    }

    protected static function renderString(\$data): string
    {
        return \$data['hello'];
    }
}
EOF;
    }

    private function getViewComponentClass()
    {
        return <<<EOF
<?php

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class TestComponent extends ContentComponent
{
    use Titantwentyone\FilamentContentComponents\Contracts\CanRenderView;

    

    public static function getField(): Block
    {
        return Block::make('test')
            ->schema([
                TextInput::make('hello')
            ]);
    }

    // This method may be deleted if \$data is to be passed directly to the view
    protected static function renderView(\$data)
    {
        return view('test', [
            'message' => \$data['hello']
        ]);
    }
}
EOF;
    }

    private function getLivewireComponentClass()
    {
        return <<<EOF
<?php

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class TestComponent extends ContentComponent
{
    use Titantwentyone\FilamentContentComponents\Contracts\CanRenderLivewire;

    // Specify the livewire component to be used with this content component
    protected static string \$component = 'livewire-component';

    public static function getField(): Block
    {
        return Block::make('test')
            ->schema([
                TextInput::make('hello')
            ]);
    }

    // This method may be deleted if \$data is to be passed directly to the livewire component
    protected static function mountArguments(\$data) : array
    {
        return array_merge(\$data, [
            'additional_data' => 'something'
        ]);
    }
}
EOF;
    }
}