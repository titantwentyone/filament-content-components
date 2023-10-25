<?php

namespace Titantwentyone\FilamentContentComponents\Fields;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;
use Titantwentyone\FilamentContentComponents\Components\InvalidComponent;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class ContentBuilder extends Builder
{
    private $components = [];

    protected function setUp() : void
    {
        parent::setUp();

        $this->afterStateHydrated(static function (Builder $component, ?array $state): void {
            $items = [];

            foreach ($state ?? [] as $itemData) {

                /** Here we are rearranging the blocks data so that the old type can be examined and the new type (currently InvalidComponent) can be changed */
                if(!$itemData['type'] || !ContentComponent::isValidType($itemData['type'])) {

                    $items[$uuid = (string) Str::uuid()] = [
                        'data' => $itemData,
                        'type' => InvalidComponent::class,
                        'old_type' => $itemData['type']
                    ];

                    //$items[$uuid = (string) Str::uuid()] = $newItemData;
                } else {
                    $items[$uuid = (string) Str::uuid()] = $itemData;
                }

            }

            $component->state($items);
        });

        $this->applyComponents();

        $this->beforeStateDehydrated(function($state, $component, $livewire, $record) {

            //modify the state of any invalid components to the new selected types
            $components_corrected = false;

            foreach($state as $uuid => $block) {
                if(array_key_exists('type', $block)) {
                    if($block['type'] == InvalidComponent::class) {
                        if($block['data']['new_type']) {
                            //update to new component
                            $state[$uuid]['type'] = $state[$uuid]['data']['new_type'];
                            $state[$uuid]['data'] = $state[$uuid]['data']['data'];
                            unset($state[$uuid]['data']['new_type']);
                            unset($state[$uuid]['old_type']);
                            $components_corrected = true;
                        } else {
                            //keep as is for now
                            $state[$uuid]['type'] = $state[$uuid]['old_type'];
                            $state[$uuid]['data'] = $state[$uuid]['data']['data'];
                            unset($state[$uuid]['data']['new_type']);
                            unset($state[$uuid]['old_type']);
                            //$state[$uuid]['data'] = $state[$uuid]['data']['data'];
                        }
                    }
                }
            }

            $component->state($state);

            /**
             * @todo currently builder will not load up with correct invalid blocks if parent was invalid - need to refresh page in order to see change
             */
            if($components_corrected) {
                redirect($livewire->getResource()::getUrl('edit', ['record' => $record]));
            }

        });
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
        if(empty($components = $this->components)) {
            $components = app('components');
        }

        $components[] = InvalidComponent::class;

        $this->childComponents(function($component) use ($components) {

            $returned = collect($components)->map(function($component) {
                return ContentBlock::make($component)
                    ->schema($component::getField())
                    ->label($component::getLabel())
                    ->validity(fn() => $component != InvalidComponent::class);
            })->toArray();

            return $returned;
        });
    }
}