<?php

namespace Tests\Fixtures\Components\StringComponents;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderString;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class StringContentComponent extends ContentComponent
{
    use CanRenderString;

    public static function getField(): array
    {
        return [
            TextInput::make('greeting'),
            TextInput::make('name')
        ];
    }

    protected static function renderString($data): string
    {
        return "{$data['greeting']} {$data['name']}";
    }
}