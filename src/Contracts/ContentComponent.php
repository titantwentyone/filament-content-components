<?php

namespace Titantwentyone\FilamentContentComponents\Contracts;

use Dotenv\Parser\Parser;
use Filament\Forms\Components\Builder\Block;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class ContentComponent extends Component
{
    public static function getField(): array
    {
        return [];
    }

    private $data = [];
    private ?string $type = null;
    private ?ContentComponent $parent = null;
    private ?array $children = null;

    final public function __construct(array $data, string $type, ContentComponent $parent = null, array $children = null)
    {
        $this->data = $data;
        $this->type = $type;
        $this->parent = $parent;
        $this->children = $children;
    }


    //public static abstract function render($data): string|View;

    public static function processRender($data, $parent = null, $children = null) : string|View
    {
        $traits = class_uses(static::class);
        $trait = collect($traits)->filter(fn($t) => Str::of($t)->contains([
            CanRenderString::class,
            CanRenderView::class,
            CanRenderLivewire::class
        ]))->first();

        $trait ?? throw new \Exception('Component must use a component trait');

        $component = new ContentComponent($data, get_class(), $parent, $children);

        $rendered = "";

        $rendered = match($trait) {
            CanRenderString::class => static::renderString($component),
            CanRenderView::class => static::renderView($component)->render(),
            CanRenderLivewire::class => static::renderLivewire($component)->html()
        };

        return $rendered;
    }

    public function getData($key = null) : string | array | null
    {
        if(isset($key) && isset($this->data[$key])) {
            return $this->data[$key];
        } elseif(!isset($key)) {
            return $this->data;
        }

        return null;
    }

    public function getParent() : ContentComponent
    {
        return $this->parent;
    }

    public function getChildren($key = null) : array
    {
        return $this->children[$key] ?? $this->children;
    }

    public function getType() : string
    {
        return $this->type;
    }
}