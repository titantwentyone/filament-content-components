<?php

namespace Titantwentyone\FilamentContentComponents\Contracts;

use Filament\Forms\Components\Builder\Block;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

abstract class ContentComponent extends Component
{
    public static abstract function getField(): array;

    //public static abstract function render($data): string|View;

    public static function processRender($data) : string|View
    {
        $rendered = "";

//        if(in_array(CanRenderString::class, class_uses(static::class)))
//        {
//            $rendered = static::renderString($data);
//        }
//
//        if(in_array(CanRenderView::class, class_uses(static::class)))
//        {
//            $rendered = static::renderView($data)->render();
//        }
//
//        if(in_array(CanRenderLivewire::class, class_uses(static::class)))
//        {
//            $rendered = static::renderLivewire($data)->html();
//        }

        $traits = class_uses(static::class);
        $trait = collect($traits)->filter(fn($t) => Str::of($t)->contains([
            CanRenderString::class,
            CanRenderView::class,
            CanRenderLivewire::class
        ]))->first();

        $trait ?? throw new \Exception('Component must use a component trait');

        $rendered = match($trait) {
            CanRenderString::class => static::renderString($data),
            CanRenderView::class => static::renderView($data)->render(),
            CanRenderLivewire::class => static::renderLivewire($data)->html()
        };

        return $rendered;
    }
}