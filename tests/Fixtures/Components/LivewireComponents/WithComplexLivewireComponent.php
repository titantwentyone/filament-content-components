<?php

namespace Tests\Fixtures\Components\LivewireComponents;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderLivewire;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class WithComplexLivewireComponent extends ContentComponent
{
    use CanRenderLivewire;

    protected static string $component = 'complex-livewire-component';

    public static function getField(): Block
    {
        return Block::make('simple-livewire-component')
        ->schema([
            TextArea::make('message')
        ]);
    }

    protected static function mountArguments($data): array
    {
        return [
            'happy' => 'I am happy'
        ];
    }
}