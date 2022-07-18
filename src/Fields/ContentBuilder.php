<?php

namespace Titantwentyone\FilamentContentComponents\Fields;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;

class ContentBuilder extends Builder
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->components();
    }

    public function getCreateItemButtonLabel() : string
    {
        return "Add Component";
    }

    public function components(array|null $components = null) : static
    {
        $components = $components ?? (config('filament-content-components.components') ?? []);

        $this->childComponents(function() use ($components) {
            return collect($components)->map(function($component) {
                return Block::make(slugifyClass($component))->schema($component::getField());
            })->toArray();
        });

        return $this;
    }
}