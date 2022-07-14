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

    public static function getField(): Block
    {
        return Block::make('simple-text-component')
            ->schema([
                TextArea::make('text')
            ]);
    }
}