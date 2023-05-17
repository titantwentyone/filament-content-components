<?php

namespace Titantwentyone\FilamentContentComponents\Fields;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\ViewField;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class ContentBuilder extends Builder
{
    protected function setUp() : void
    {
        parent::setUp();

        $this->components();
    }

    /**
     * @codeCoverageIgnore
     */
    public function getCreateItemButtonLabel() : string
    {
        return "Add Component";
    }

    public function components(array $components = []) : static
    {
        if(count(config('filament-content-components.components'))) {
            $components = config('filament-content-components.components');
        } else {
            //$components = count($components) ?: app('components');
            if(!count($components)) {
                $components = app('components');
            }
        }

        $this->childComponents(function() use ($components) {
            return collect($components)->map(function($component) {
                return Block::make(slugifyClass($component))
                    ->schema($component::getField());
            })->toArray();
        });

        return $this;
    }
}