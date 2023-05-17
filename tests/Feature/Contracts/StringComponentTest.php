<?php

it('can handle different field names for content', function() {

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
->covers(\Titantwentyone\FilamentContentComponents\Contracts\CanRenderString::class);

it('will render multiple components', function () {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'text' => [
            [
                'data' => [
                    'greeting' => 'greetings',
                    'name' => 'Bob'
                ],
                'type' => 'string-components.string-content-component'
            ],
            [
                'data' => [
                    'greeting' => 'hello',
                    'name' => 'Jane'
                ],
                'type' => 'string-components.string-content-component'
            ]
        ]
    ]);

    $this->assertEquals('greetings Bobhello Jane', $page->parsedText);

})
->covers(\Titantwentyone\FilamentContentComponents\Contracts\CanRenderString::class);

it('will handle empty content', function () {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'text' => []
    ]);

    $this->assertEquals('', $page->parsedText);

})
->covers(\Titantwentyone\FilamentContentComponents\Contracts\CanRenderString::class);

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
->covers(\Titantwentyone\FilamentContentComponents\Contracts\CanRenderString::class);

it('will render a string component with overriden render method', function () {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'text' => [
            [
                'data' => [
                    'greeting' => 'hello',
                    'name' => 'geoff'
                ],
                'type' => 'string-components.string-content-component'
            ]
        ]
    ]);

    $this->assertEquals('hello geoff', $page->parsedText);

})
->covers(\Titantwentyone\FilamentContentComponents\Contracts\CanRenderString::class);

test('filament will correctly populate the content field', function () {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'text' => 'Just rendering a string'
                ],
                'type' => 'simple-text-without-view'
            ]
        ]
    ]);

    $expected = [
        'data' => [
            'text' => 'Just rendering a string'
        ],
        'type' => 'simple-text-without-view'
    ];

    \Pest\Livewire\livewire(\Tests\Fixtures\Filament\Resources\PageResource\Pages\EditPage::class, [
        'record' => $page->getKey()
    ])
        ->assertArrayValueAtIndexEquals($expected, 'data.content', 0);
})
->covers(\Titantwentyone\FilamentContentComponents\Contracts\CanRenderString::class);

it('will output the string', function () {

    $data = [
        'greeting' => 'Congratulations',
        'name' => 'Bob'
    ];

    $this->assertEquals('Congratulations Bob', \Tests\Fixtures\Components\StringComponents\StringContentComponent::processrender($data));

})
->covers(\Titantwentyone\FilamentContentComponents\Contracts\CanRenderString::class);