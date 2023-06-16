<?php

namespace Titantwentyone\FilamentContentComponents\Contracts;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;
use ReflectionClass;

trait CanRenderView
{
    protected static function renderView(array $data) : View
    {
        $view = static::$view ?? static::getViewPath($data);

        $view_folder = config('filament-content-components.view_root') ? config('filament-content-components.view_root')."." : '';

        $view = $view_folder.$view;

        return view($view, [
            'data' => $data
        ]);
    }

    protected static function getViewPath(array $data) : string
    {
        $namespace = Str::of(getNamespace(static::class))
            ->remove(config('filament-content-components.namespace'))
            ->replace('\\', '.')
            ->headline()
            ->slug();

        $view = Str::of(class_basename(static::class))
            ->headline()
            ->slug();

        //return implode('.', array_filter([$namespace, $view]));
        return Str::of(Arr::join([$namespace, $view], '.'))->trim('.');
    }
}