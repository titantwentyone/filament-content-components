<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

if(!function_exists('parseContentComponent'))
{
    /**
     * @param $item array component to be parsed
     * @return string rendered output of component
     */
    function parseContentComponent(array $item) : string
    {
        $component_parts = explode('.', $item['type']);

        $component_parts = collect($component_parts)->map(function($part) {
            return Str::of($part)
                ->title()
                ->replace('-', '');
        });

        $component_name = Arr::join($component_parts->toArray(), '\\');

        $component = config('filament-content-components.namespace')."\\".$component_name;
        return $component::processRender($item['data']);
    }
}

if(!function_exists('getNamespace'))
{
    function getNamespace($classname) :string
    {
        //return (new ReflectionClass(static::class))->getNamespaceName();
        return (new ReflectionClass($classname))->getNamespaceName();
    }
}

if(!function_exists('slugifyClass'))
{
    function slugifyClass($classname)
    {
        $namespace = Str::of(getNamespace($classname))
            ->remove(config('filament-content-components.namespace'))
            ->replace('\\', '.')
            ->headline()
            ->slug();

        $class = Str::of(class_basename($classname))
            ->headline()
            ->slug();

        return Str::of(Arr::join([$namespace, $class], '.'))->trim('.')->toString();
    }
}