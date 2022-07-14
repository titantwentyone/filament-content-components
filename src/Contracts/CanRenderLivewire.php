<?php

namespace Titantwentyone\FilamentContentComponents\Contracts;

use Exception;
use Livewire\Livewire;
use Livewire\Response;

trait CanRenderLivewire
{
    protected static function renderLivewire($data) : Response
    {
        static::$component ?? throw new Exception('no component property defined');

        return Livewire::mount(static::$component, array_merge(
            ['data' => $data],
            static::mountArguments($data)
        ));
    }

    protected static function mountArguments($data) : array
    {
        return [];
    }
}