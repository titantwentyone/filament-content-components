<?php

namespace Titantwentyone\FilamentContentComponents\Components;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class InvalidComponent extends ContentComponent
{
    public static function getField(): array
    {
        return [
            Grid::make()
                ->schema(function($livewire, $component) {

                    $components = [];

                    $components[] = Placeholder::make('Invalid Component')
                        ->columnSpan(2)
                        ->content(<<<EOF
                            This component is invalid and cannot be edited correctly.
                            The old value of the component type is shown below. To update it, select a value from "New Type".
                            Changing the type does not guarantee the properties of the old component will be transfered correctly to the new one.
                            The component, while invalid, will not be rendered on the front-end of the site.
                        EOF);

                    $components[] = KeyValue::make('data')
                        ->dehydrated(false)
                        ->columnSpan(2)
                        ->disabled();

                    $components[] = TextInput::make('type')
                        ->dehydrated(false)
                        ->disabled()
                        ->label('Old Type');

                    $components[] = Select::make('new_type')
                        //->dehydrated(false)
                        //->statePath('data.data.new_type')
                        ->options(fn() => collect(app('components'))->mapWithKeys(fn($item) => [$item => $item]));
                        //->required();
                        //->beforeStateDehydrated(fn() => dd('stop'));

                    return $components;

                })
        ];
    }
}