<?php

namespace Titantwentyone\FilamentContentComponents\Fields;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\ViewField;
use Illuminate\Contracts\View\View;

class PreviewField extends ViewField
{
    private string $component_type = '';

    protected string $view = 'filament-content-components::preview';

    public function setComponentType(string $type) : static
    {
        $this->component_type = $type;

        return $this;
    }

    public function render(): View
    {
        return view(
            $this->getView(),
            array_merge(
                $this->data(),
                isset($this->viewIdentifier) ? [$this->viewIdentifier => $this] : [],
                ['component_type' => $this->component_type]
            ),
        );
    }

//    public function getState()
//    {
//        $state = data_get($this->getLivewire(), str_replace('.data.preview', '', $this->getStatePath()));
//        unset($state['data']['preview']);
//
//        if (is_array($state)) {
//            return $state;
//        }
//
//        if (blank($state)) {
//            return null;
//        }
//
//        return $state;
//    }

//    public function getState()
//    {
//        $state = parent::getState();
//
//        unset($state['data']['preview']);
//
//        if (is_array($state)) {
//            return $state;
//        }
//
//        if (blank($state)) {
//            return null;
//        }
//
//        return $state;
//    }
//
//    public function getStatePath(bool $isAbsolute = true): string
//    {
//        //return str_replace('.data.preview', '', parent::getStatePath());
//        //return rtrim(parent::getStatePath(), '.data.preview');
//        return substr(0, -strlen('.data.preview'));
//    }
}