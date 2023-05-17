<?php

it('will return the correct content for a field', function() {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'text' => [
            [
                'data' => [
                    'text' => 'Different field used'
                ],
                'type' => 'view-components.view-content-component'
            ]
        ]
    ]);

    $this->assertEquals('Different field used', $page->parsedText);

})
->covers(\Titantwentyone\FilamentContentComponents\Concerns\HasContent::class);