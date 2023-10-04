<?php

namespace Titantwentyone\FilamentContentComponents;

class ComponentRegister
{
    private static array $components = [];
    public static function registerComponents(array $components) {
        static::$components = collect(array_merge(static::$components, $components))->unique()->toArray();
    }

    public static function bindComponents()
    {
        app()->instance('components', static::$components);
    }
}