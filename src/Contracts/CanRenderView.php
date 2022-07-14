<?php

namespace Titantwentyone\FilamentContentComponents\Contracts;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;
use ReflectionClass;

trait CanRenderView
{
    /**
     * @return string
     */
    private static function getNamespace(): string
    {
        return (new ReflectionClass(static::class))->getNamespaceName();
    }

    protected static function renderView(array $data) : View
    {
        $view = static::$view ?? static::getViewPath($data);

        return view($view, [
            'data' => $data
        ]);
    }

    protected static function getViewPath(array $data) : string
    {
        $namespace = Str::of(static::getNamespace())
            ->remove(config('filament-content-components.namespace'))
            ->replace('\\', '.')
            ->headline()
            ->slug();

        $view = Str::of(class_basename(static::class))
            ->headline()
            ->slug();

        //return implode('.', array_filter([$namespace, $view]));
        return Arr::join([$namespace, $view], '.');
    }
}