<?php

namespace Titantwentyone\FilamentContentComponents\Fields;

use Filament\Forms\Components\Concerns;
use Illuminate\Contracts\Support\Htmlable;
use Psy\Util\Str;

class ContentBlock extends \Filament\Forms\Components\Builder\Block
{
    private $validity;

    use Concerns\HasName {
        getName as getName;
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }

    public function getLabel(?array $state = null, ?string $uuid = null): string | Htmlable
    {
        return $this->evaluate(
            $this->label,
            ['state' => $state, 'uuid' => $uuid],
        ) ?? $this->getDefaultLabel();
    }

    public function isValid()
    {
        return $this->evaluate($this->validity);
    }

    public function validity(string | \Closure $callback)
    {
        $this->validity = $callback;

        return $this;
    }

    public function statePath(?string $path): static
    {
        if($this->isValid()) {
            $this->statePath = $path;
        } else {
            $this->statePath = \Illuminate\Support\Str::of($path)->replaceLast('.data', '');
        }

        return $this;
    }
}