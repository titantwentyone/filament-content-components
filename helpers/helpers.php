<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

if(!function_exists('parseContentComponent'))
{
    /**
     * @param $item array component to be parsed
     * @return string rendered output of component
     */
    function parseContentComponent(array $item, $parent = null, $children = null) : string
    {
        $component_parts = explode('.', $item['type']);

        $component_parts = collect($component_parts)
            ->map(function($part) {
                return Str::of($part)
                        ->ucfirst()
                        ->replace('-', '');
                });

        $component_name = '\\'.Arr::join($component_parts->toArray(), '\\');

        //$component = config('filament-content-components.namespace')."\\".$component_name;
        $component = $component_name;

        if(class_exists($component)) {
            if (!method_exists($component, 'processRender')) {
                throw new \BadMethodCallException('Method processRender not found on ' . $component . '. Have you extended from ' . \Titantwentyone\FilamentContentComponents\Contracts\ContentComponent::class);
            }
        } else {
            throw new \Exception("The class {$component} does not exist");
        }

        return $component::processRender($item['data'], $parent, $children);
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
        /**
        $namespace = Str::of(getNamespace($classname))
            //->remove(config('filament-content-components.namespace'))
            ->replace('\\', '.')
            //->headline()
            ->slug();

//        dump(config('filament-content-components.namespace'));
//        dump(getNamespace($classname));
//        dump($namespace);

        $class = Str::of(class_basename($classname))
            ->headline()
            ->slug();

        //dd($class);

        return Str::of(Arr::join([$namespace, $class], '.'))->trim('.')->toString();
         */
        return Str::of($classname)->replace('\\', '.');
        //return $classname;
    }
}