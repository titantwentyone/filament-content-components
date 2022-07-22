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
            $output .= parseContentComponent($item);
        }

        return $output;
    }
}