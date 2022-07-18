<?php

namespace Tests\Fixtures\Components\ViewComponents;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderView;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class ViewContentComponent extends ContentComponent
{
    use CanRenderView;

    //protected static string $view = 'simple-text-component';

    public static function getField(): array
    {
        return [
            TextArea::make('text')
        ];
    }
}