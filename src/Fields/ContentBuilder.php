<?php

namespace Titantwentyone\FilamentContentComponents\Fields;

use Filament\Forms\Components\Builder;

class ContentBuilder extends Builder
{
    protected function setUp() : void
    {
        $this->blocks([]);
    }

    public function getCreateItemButtonLabel() : string
    {
        return "";
    }

    protected function components(array|null $components = null) : void
    {
        $this->blocks(collect(config('filament-cms.components'))->each(function($component) {
            return $component::getField();
        })->toArray());
    }
}