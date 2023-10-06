<?php

it('will render a view component', function() {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'text' => 'Some text here'
                ],
                'type' => 'Tests\\Fixtures\\Components\\ViewComponents\\ViewContentComponent'
            ]
        ]
    ]);

    $this->assertEquals('Some text here', $page->parsedContent);
});

it('will render a view component with overriden render method', function () {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'text' => 'Amazing!!'
                ],
                'type' => 'Tests\\Fixtures\\Components\\ViewComponents\\ViewContentComponentWithOverriddenMethod'
            ]
        ]
    ]);

    $this->assertEquals('Amazing!!', $page->parsedContent);

})
->covers(\Tests\Fixtures\Components\ViewComponents\ViewContentComponent::class);

it('will render a view component with overriden view property', function () {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'text' => 'Amazing!!'
                ],
                'type' => 'Tests\\Fixtures\\Components\\ViewComponents\\ViewContentComponentWithOverriddenViewProperty'
            ]
        ]
    ]);

    $this->assertEquals('Amazing!!', $page->parsedContent);

})
->covers(\Tests\Fixtures\Components\ViewComponents\ViewContentComponent::class);

it('will render a view component with overridden get view method', function () {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'happy' => 'no'
                ],
                'type' => 'Tests\\Fixtures\\Components\\ViewComponents\\ViewContentComponentWithOverriddenGetViewMethod'
            ]
        ]
    ]);

    $this->assertEquals("I'm sorry you're not happy. :(", $page->parsedContent);

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'happy' => 'yes'
                ],
                'type' => 'Tests\\Fixtures\\Components\\ViewComponents\\ViewContentComponentWithOverriddenGetViewMethod'
            ]
        ]
    ]);

    $this->assertEquals("I'm glad you're happy!", $page->parsedContent);

})
->covers(\Tests\Fixtures\Components\ViewComponents\ViewContentComponent::class);

it('will output the view', function () {

    $data = [
        'text' => 'a short message'
    ];

    $component = new \Titantwentyone\FilamentContentComponents\Contracts\ContentComponent($data, \Tests\Fixtures\Components\ViewComponents\ViewContentComponent::class);

    $this->assertEquals(
        view('view-components.view-content-component', ['data' => $component->getData()]),
        \Tests\Fixtures\Components\ViewComponents\ViewContentComponent::processRender($data)
    );

    $data = [
        'happy' => 'yes'
    ];

    $component = new \Titantwentyone\FilamentContentComponents\Contracts\ContentComponent($data, \Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenGetViewMethod::class);

    $this->assertEquals(
        view('view-components.happy', ['data' => $component->getData()]),
        \Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenGetViewMethod::processRender($data)
    );

    $data = [
        'text' => 'a short message'
    ];

    $component = new \Titantwentyone\FilamentContentComponents\Contracts\ContentComponent($data, \Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenMethod::class);

    $this->assertEquals(
        view('simple-text-component-different-view', ['differentdata' => $component->getData()]),
        \Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenMethod::processRender($data)
    );

    $data = [
        'text' => 'another short message'
    ];

    $component = new \Titantwentyone\FilamentContentComponents\Contracts\ContentComponent($data, \Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenViewProperty::class);

    $this->assertEquals(
        view('custom.view.path.my-component', ['data' => $component->getData()]),
        \Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenViewProperty::processRender($data)
    );
})
->covers(\Tests\Fixtures\Components\ViewComponents\ViewContentComponent::class);