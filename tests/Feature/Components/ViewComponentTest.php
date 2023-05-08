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
                'type' => 'view-components.view-content-component'
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
                'type' => 'view-components.view-content-component-with-overridden-method'
            ]
        ]
    ]);

    $this->assertEquals('Amazing!!', $page->parsedContent);

});

it('will render a view component with overriden view property', function () {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'text' => 'Amazing!!'
                ],
                'type' => 'view-components.view-content-component-with-overridden-view-property'
            ]
        ]
    ]);

    $this->assertEquals('Amazing!!', $page->parsedContent);

});

it('will render a view component with overridden get view method', function () {

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'happy' => 'no'
                ],
                'type' => 'view-components.view-content-component-with-overridden-get-view-method'
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
                'type' => 'view-components.view-content-component-with-overridden-get-view-method'
            ]
        ]
    ]);

    $this->assertEquals("I'm glad you're happy!", $page->parsedContent);

});

it('will output the view', function () {

    $data = [
        'text' => 'a short message'
    ];

    $this->assertEquals(
        view('view-components.view-content-component', ['data' => $data]),
        \Tests\Fixtures\Components\ViewComponents\ViewContentComponent::processRender($data)
    );

    $data = [
        'happy' => 'yes'
    ];

    $this->assertEquals(
        view('view-components.happy', ['data' => $data]),
        \Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenGetViewMethod::processRender($data)
    );

    $data = [
        'text' => 'a short message'
    ];

    $this->assertEquals(
        view('simple-text-component-different-view', ['differentdata' => $data]),
        \Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenMethod::processRender($data)
    );

    $data = [
        'text' => 'another short message'
    ];

    $this->assertEquals(
        view('custom.view.path.my-component', ['data' => $data]),
        \Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenViewProperty::processRender($data)
    );
});