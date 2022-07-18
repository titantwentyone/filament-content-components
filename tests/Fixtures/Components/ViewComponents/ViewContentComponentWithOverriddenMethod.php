<?php

namespace Tests\Fixtures\Components\ViewComponents;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Illuminate\View\View;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderView;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class ViewContentComponentWithOverriddenMethod extends ContentComponent
{
    use CanRenderView;

    protected static string $view = 'simple-text-component';

    public static function getField(): array
    {
        return [
            TextArea::make('text')
        ];
    }

    public static function renderView($data): View
    {
        return view('simple-text-component-different-view', [
            'differentdata' => $data
        ]);
    }


}