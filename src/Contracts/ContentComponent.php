<?php

namespace Titantwentyone\FilamentContentComponents\Contracts;

use Filament\Forms\Components\Builder\Block;
use Illuminate\View\View;
use Livewire\Component;

abstract class ContentComponent extends Component
{
    public static abstract function getField(): Block;

    //public static abstract function render($data): string|View;

    public static function processRender($data) : string|View
    {
        $rendered = "";

        if(in_array(CanRenderString::class, class_uses(static::class)))
        {
            $rendered = static::renderString($data);
        }

        if(in_array(CanRenderView::class, class_uses(static::class)))
        {
            $rendered = static::renderView($data)->render();
        }

        if(in_array(CanRenderLivewire::class, class_uses(static::class)))
        {
            $rendered = static::renderLivewire($data)->html();
        }

        return $rendered;
    }
}