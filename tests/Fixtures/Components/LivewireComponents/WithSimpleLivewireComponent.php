<?php

namespace Tests\Fixtures\Components\LivewireComponents;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderLivewire;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class WithSimpleLivewireComponent extends ContentComponent
{
    use CanRenderLivewire;

    protected static string $component = 'simple-livewire-component';

    public static function getField(): Block
    {
        return Block::make('simple-livewire-component')
        ->schema([
            TextArea::make('message')
        ]);
    }
}