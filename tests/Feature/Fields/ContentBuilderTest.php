<?php

use Tests\Fixtures\Components\LivewireComponents\WithComplexLivewireComponent;
use Tests\Fixtures\Components\StringComponents\StringContentComponent;

it('will allow components when defined on component', function () {

    $page = new class extends \Filament\Pages\Page {};
    $container = new \Filament\Forms\ComponentContainer(new $page());

    $builder = \Titantwentyone\FilamentContentComponents\Fields\ContentBuilder::make('builder')
        ->components([
            \Tests\Fixtures\Components\LivewireComponents\WithSimpleLivewireComponent::class
        ])
        ->container($container);

    $this->assertEquals(2, count($builder->getChildComponents()));
})
->covers(\Titantwentyone\FilamentContentComponents\Fields\ContentBuilder::class);

it('will display an error in the back end when the component does not exist', function () {

    /**
     * baseline test
     * to verify that a valid component will result in a child component container
     */

    $baseline_content = [
        [
            "data" => [
                "text" => "<p>Some text here</p>"
            ],
            "type" => "Tests\\Fixtures\\Components\\StringComponents\\StringContentComponent"
        ]
    ];

    $baseline_page = \Tests\Fixtures\Models\Page::create([
        'title' => 'Test Page',
        'slug' => 'test-page',
        'content' => $baseline_content
    ]);

    \Pest\Livewire\livewire(\Tests\Fixtures\Filament\Resources\PageResource\Pages\EditPage::class, [
        'record' => $baseline_page->id
    ])
        ->assertFormFieldExists('content', function(\Titantwentyone\FilamentContentComponents\Fields\ContentBuilder $builder) {
            /** @var $container \Filament\Forms\ComponentContainer */
            $container = collect($builder->getChildComponentContainers())->first();
            //dump($container->getParentComponent()->getName());
            return collect($builder->getChildComponentContainers())->count() == 1
                && $container->getParentComponent()->getName() == "Tests\\Fixtures\\Components\\StringComponents\\StringContentComponent";
        });



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
        'title' => 'Test Page',
        'slug' => 'test-page',
        'content' => $content
    ]);

    \Pest\Livewire\livewire(\Tests\Fixtures\Filament\Resources\PageResource\Pages\EditPage::class, [
        'record' => $page->id
    ])
    ->assertFormFieldExists('content', function(\Titantwentyone\FilamentContentComponents\Fields\ContentBuilder $builder) {
        /** @var $container \Filament\Forms\ComponentContainer */
        $container = collect($builder->getChildComponentContainers())->first();
        return collect($builder->getChildComponentContainers())->count() == 1
            && $container->getParentComponent()->getName() == 'Titantwentyone\\FilamentContentComponents\\Components\\InvalidComponent'
            && count($container->getComponents()) == 1;
    });

});

it('will hide a component on the front end when the component does not exist', function () {

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
        'title' => 'Test Page',
        'slug' => 'test-page',
        'content' => $content
    ]);

    $page->parsedContent;


});

/**
 * enable an array which maps old component types to new ones. The user can gradually, over time, replace these with new components.
 * Look at cloning a component which will automtcailly create a new component with the correct type
 */
it('will use a temporary map to identify old components', function () {

});