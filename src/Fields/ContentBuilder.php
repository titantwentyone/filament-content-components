<?php

namespace Titantwentyone\FilamentContentComponents\Fields;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\ViewField;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class ContentBuilder extends Builder
{
    protected function setUp() : void
    {
        parent::setUp();

//        $this->afterStateHydrated(static function (Builder $component, ?array $state, callable $set): void {
//            $items = collect($state ?? [])
//                ->mapWithKeys(static fn ($itemData) => [(string) Str::uuid() => $itemData])
//                ->toArray();
//
//            $component->state($items);
//
//            //$set('preview', $items);
//        });

        $this->components();
    }

    public function getCreateItemButtonLabel() : string
    {
        return "Add Component";
    }

    public function components(array|null $components = null) : static
    {
        $components = $components ?? (config('filament-content-components.components') ?? []);

        $this->childComponents(function() use ($components) {
            return collect($components)->map(function($component) {
                return Block::make(slugifyClass($component))
                    ->schema($component::getField());

//                return Block::make(slugifyClass($component))
//                    ->reactive()
//                    ->afterStateHydrated(function(callable $set, $state) {
//                        if ($state)
//                        {
//                            //dd($state);
//                            //unset($state['data']['preview']);
//                            $set('preview', $state);
//                        }
//                        //$set('preview', $state);
//                    })
//                return Block::make('component')
//                    ->schema([
//                        Tabs::make('controls')
//                            ->tabs([
//                                Tab::make('Control')
//                                    ->schema($component::getField()),
//                                Tab::make('Preview')
//                                    ->icon('heroicon-o-eye')
//                                    ->schema([
//                                        PreviewField::make('preview')
//                                            //->setComponentType(slugifyClass($component))
//                                    ])
//                            ])
//                    ]);
            })->toArray();
        });

        return $this;
    }
}