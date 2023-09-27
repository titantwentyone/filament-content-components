<?php

namespace Titantwentyone\FilamentContentComponents\Contracts;

use Exception;
use Livewire\Livewire;
use Livewire\Response;

trait CanRenderLivewire
{
    protected static function renderLivewire(ContentComponent $component) : Response
    {
        static::$component ?? throw new Exception('no component property defined');

        return Livewire::mount(static::$component, array_merge(
            $component->getData(),
            static::mountArguments($component->getData())
        ));
    }

    protected static function mountArguments($data) : array
    {
        return [];
    }
}