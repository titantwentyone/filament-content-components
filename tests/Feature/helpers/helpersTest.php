<?php

it('will get the namespace of a class', function() {

    expect(getNamespace(\Tests\Fixtures\Components\LivewireComponents\WithSimpleLivewireComponent::class))
        ->toBe("Tests\Fixtures\Components\LivewireComponents");
});

it('will slugify a class', function () {

    expect(slugifyClass(\Tests\Fixtures\Components\InvalidComponent::class))
        ->toBe('Tests.Fixtures.Components.InvalidComponent');

    expect(slugifyClass(\Tests\Fixtures\Components\LivewireComponents\WithSimpleLivewireComponent::class))
        ->toBe('Tests.Fixtures.Components.LivewireComponents.WithSimpleLivewireComponent');

});