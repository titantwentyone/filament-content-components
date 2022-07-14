<?php

namespace Titantwentyone\FilamentContentComponents\Contracts;

trait CanRenderString
{
    protected abstract static function renderString($data) : string;
}