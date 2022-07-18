<?php

namespace Tests\Fixtures\Components\StringComponents;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderString;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class StringContentComponentWithOverriddenMethod  extends ContentComponent
{
    use CanRenderString;

    public static function getField(): array
    {
        return [
            TextArea::make('text')
        ];
    }

    public static function renderString($data) : string
    {
        return $data['text'];
    }
}