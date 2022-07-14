<?php

namespace Tests\Fixtures\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Tests\Fixtures\Filament\Resources\PageResource\Pages\CreatePage;
use Tests\Fixtures\Filament\Resources\PageResource\Pages\EditPage;
use Tests\Fixtures\Filament\Resources\PageResource\Pages\ListPages;
use Tests\Fixtures\Models\Page;
use Titantwentyone\FilamentContentComponents\Fields\ContentBuilder;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    public static function form(Form $form) : Form
    {
        return $form->schema([
            TextInput::make('title'),
            ContentBuilder::make('content')
        ]);
    }

    public static function getPages() : array
    {
        return [
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit')
        ];
    }
}