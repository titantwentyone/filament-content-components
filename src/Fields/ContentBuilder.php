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
    private $components = [];

    protected function setUp() : void
    {
        parent::setUp();
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
        if(!count($components)) {

            if(config('filament-content-components.components') && count(config('filament-content-components.components'))) {
                $components = config('filament-content-components.components');
            } else {
                //$components = count($components) ?: app('components');
                if(!count($components)) {
                    $components = app('components');
                }
            }

        }

        $this->components = $components;

        $this->applyComponents();

        return $this;
    }

    public function applyComponents(): void
    {
        $components = $this->components;

        $this->childComponents(function() use ($components) {
            return collect($components)->map(function($component) {
                return Block::make(slugifyClass($component))
                    ->schema($component::getField());
            })->toArray();
        });
    }
}