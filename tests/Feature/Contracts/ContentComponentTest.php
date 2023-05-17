<?php

it('will render a string component', function () {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'text' => [
            [
                'data' => [
                    'greeting' => 'hello',
                    'name' => 'Jane'
                ],
                'type' => 'string-components.string-content-component'
            ]
        ]
    ]);

    $this->assertEquals('hello Jane', $page->parsedText);
})
->covers(\Titantwentyone\FilamentContentComponents\Contracts\ContentComponent::class);

it('will render a view component', function () {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'text' => 'Some text here'
                ],
                'type' => 'view-components.view-content-component'
            ]
        ]
    ]);

    $this->assertEquals('Some text here', $page->parsedContent);
})
->covers(\Titantwentyone\FilamentContentComponents\Contracts\ContentComponent::class);

it('will render a livewire component', function() {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'message' => 'Just a simple message'
                ],
                'type' => 'livewire-components.with-simple-livewire-component'
            ]
        ]
    ]);

    $expected = [
        'data' => [
            'message' => 'Just a simple message'
        ],
        'type' => 'livewire-components.with-simple-livewire-component'
    ];

    $this->assertStringContainsString('Just a simple message', $page->parsedContent);
    $this->assertStringContainsString('from livewire', $page->parsedContent);

})
->covers(\Titantwentyone\FilamentContentComponents\Contracts\ContentComponent::class);

it('will throw an exception if the component does not use a valid trait', function () {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'message' => 'Just a simple message'
                ],
                'type' => 'invalid-component'
            ]
        ]
    ]);

    $page->parsedContent;
})
->covers(\Titantwentyone\FilamentContentComponents\Contracts\ContentComponent::class)
->throws(Exception::class);