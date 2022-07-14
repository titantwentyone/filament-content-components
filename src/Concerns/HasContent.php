<?php

namespace Titantwentyone\FilamentContentComponents\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

trait HasContent
{
    public function __get($name) : mixed
    {
        $parsed = null;

        if(Str::startsWith($name, 'parsed'))
        {
            $field = strtolower(Str::afterLast($name, 'parsed'));

            $parsed = $this->parse($field);
        }

        return $parsed ?? $this->getAttribute($name);
    }

    private function parse($field) : string
    {
        $content_items = $this->$field;

        $output = "";

        foreach($content_items as $item) {
            //$component_name = str_replace('-', '', Str::title($item['type']));

            $component_parts = explode('.', $item['type']);

            $component_parts = collect($component_parts)->map(function($part) {
                return Str::of($part)
                    ->title()
                    ->replace('-', '');
            });

            //$component_name = implode('\\', array_filter($component_parts->toArray()));
            $component_name = Arr::join($component_parts->toArray(), '\\');

            $component = config('filament-content-components.namespace')."\\".$component_name;
            $output .= $component::processRender($item['data']);
        }

        return $output;
    }
}