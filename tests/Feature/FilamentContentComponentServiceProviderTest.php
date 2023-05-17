<?php

it('can register components', function() {

    $this->assertEquals(8, count(app('components')));
})
->covers(\Titantwentyone\FilamentContentComponents\FilamentContentComponentsServiceProvider::class);