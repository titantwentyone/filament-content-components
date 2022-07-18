<?php

namespace Tests\Fixtures\Components\ViewComponents;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderView;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class ViewContentComponentWithOverriddenGetViewMethod extends ContentComponent
{
    use CanRenderView;

    public static function getField(): array
    {
        return [
            Select::make('happy')
                ->options([
                    'yes' => 'Yes',
                    'no' => 'No'
                ])
        ];
    }

    public static function getViewPath($data): string
    {
        return match($data['happy']) {
            'yes' => 'view-components.happy',
            'no' => 'view-components.not-happy'
        };
    }
}