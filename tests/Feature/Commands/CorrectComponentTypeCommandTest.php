<?php

it('will throw an error if the model does not exist', function () {

    $this->artisan('fcc:correct', [
        'model' => 'non_existant_class',
        'field' => 'content',
        'old' => 'text-component',
        'new' => \Tests\Fixtures\Components\StringComponents\StringContentComponent::class
    ]);
})
->throws(\Exception::class)
->expectExceptionMessage('Model non_existant_class does not exist');

it('will throw an error if the the field on the model does not exist', function () {

    $this->artisan('fcc:correct', [
        'model' => \Tests\Fixtures\Models\Page::class,
        'field' => 'non_existant_field',
        'old' => 'text-component',
        'new' => \Tests\Fixtures\Components\StringComponents\StringContentComponent::class
    ]);
})
->throws(\Exception::class)
->expectExceptionMessage('Field non_existant_field on Tests\Fixtures\Models\Page does not exist');

it('will throw an error if the component does not exist', function () {

    $this->artisan('fcc:correct', [
        'model' => \Tests\Fixtures\Models\Page::class,
        'field' => 'content',
        'old' => 'text-component',
        'new' => 'non_existant_component'
    ]);
})
->throws(\Exception::class)
->expectExceptionMessage('Component non_existant_component does not exist');

it('will convert a type', function() {

    $content = [
        [
            "data" => [
                "count" => "2",
                "column_0" => [],
                "column_1" => [
                    [
                        "data" => [
                        "text" => "<p>Some text here</p>"
                    ],
                        "type" => "text-component"
                    ]
                ],
                "column_2" => []
                ],
            "type" => "columns"
        ]
    ];

    $page = \Tests\Fixtures\Models\Page::create([
        'title' => 'Test Title',
        'slug' => 'test-title',
        'content' => $content
    ]);

    expect($page->content)->toBe($content);

    $this->artisan('fcc:correct', [
        'model' => \Tests\Fixtures\Models\Page::class,
        'field' => 'content',
        'old' => 'text-component',
        'new' => \Tests\Fixtures\Components\StringComponents\StringContentComponent::class
    ]);

    $expected_content = [
        [
            "data" => [
                "count" => "2",
                "column_0" => [],
                "column_1" => [
                    [
                        "data" => [
                            "text" => "<p>Some text here</p>"
                        ],
                        "type" => "Tests\Fixtures\Components\StringComponents\StringContentComponent"
                    ]
                ],
                "column_2" => []
            ],
            "type" => "columns"
        ]
    ];

    $page->refresh();

    expect($page->content)->toBe($expected_content);

});