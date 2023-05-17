<?php

namespace Tests\Fixtures\Components;

use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class InvalidComponent extends ContentComponent
{
    public static function getField(): array
    {
        return [];
    }
}