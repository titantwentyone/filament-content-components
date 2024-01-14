<?php

namespace Tests\Concerns;

use Orchestra\Testbench\TestCase;

/** @mixin TestCase */
trait HasInlineResourceFixture
{
    private string $resourceClass;

    private string $createClass;

    private string $editClass;

    private string $listClass;

    private array $resourceClassForm = [];

    protected function getResourceClass(): string
    {
        return $this->resourceClass;
    }

    protected function getCreateClass(): string
    {
        return $this->createClass;
    }

    protected function getEditClass(): string
    {
        return $this->editClass;
    }

    protected function getListClass(): string
    {
        return $this->listClass;
    }

    protected function getPackageProviders($app): array
    {
        $panelProvider = $this->generateInlineResource();

        return array_merge(parent::getPackageProviders($app), [
            $panelProvider
        ]);
    }

    protected function resourceClassForm(\Closure|array $fields)
    {
        $reflected = new \ReflectionClass($this->resourceClass);
        $reflected->setStaticPropertyValue('_form', $fields);
    }

    /**
     * @return mixed
     */
    public function generateInlineResource(): mixed
    {
        [$this->resourceClass, $this->createClass, $this->editClass, $this->listClass, $panelProvider] = eval(
        <<<EOL
                namespace App\Filament;
            
                use \Filament\Panel;
                use \Filament\Resources\Pages\CreateRecord;

                class CR extends \Filament\Resources\Pages\CreateRecord
                {
                    protected static string \$resource = RE::class;
                }
                
                class ER extends \Filament\Resources\Pages\EditRecord
                {
                    protected static string \$resource = RE::class;
                }
                
                class LR extends \Filament\Resources\Pages\ListRecords
                {
                    protected static string \$resource = RE::class;
                }
                
                class RE extends \Filament\Resources\Resource
                {
                    public static Closure|array \$_form = [];
                    
                    public static function form(\Filament\Forms\Form \$form): \Filament\Forms\Form
                    {
                        if(static::\$_form instanceof \Closure) {
                            return static::\$_form();
                        }
                        
                        return \$form->schema(static::\$_form);
                    }
                    
                    public static function getPages(): array
                    {
                        return [
                            'create' => CR::route('/create'),
                            'index' => LR::route('/')
                        ];
                    }
                };
                
                class PP extends \Filament\PanelProvider
                {
                    public function panel(Panel \$panel): Panel
                    {
                        return \$panel
                            ->id('testing')
                            ->default()
                            ->resources([
                                RE::class
                            ])
                            ->middleware([
                                \Filament\Http\Middleware\DisableBladeIconComponents::class,
                                \Filament\Http\Middleware\DispatchServingFilamentEvent::class,
                                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                                \Illuminate\Session\Middleware\AuthenticateSession::class,
                                \Illuminate\Session\Middleware\StartSession::class,
                                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                                \Orchestra\Testbench\Http\Middleware\VerifyCsrfToken::class,
                            ]);
                    }
                }
                
                return [RE::class, CR::class, ER::class, LR::class, PP::class];
            EOL);

        return $panelProvider;
    }

}