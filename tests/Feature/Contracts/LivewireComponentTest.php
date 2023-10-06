<?php

use Tests\Fixtures\Filament\Resources\PageResource\Pages\EditPage;
use Tests\Fixtures\Models\Page;
use Tests\Fixtures\Models\User;

it('will render a simple livewire component', function() {

    $page = Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'message' => 'Just a simple message'
                ],
                'type' => 'Tests\\Fixtures\\Components\\LivewireComponents\\WithSimpleLivewireComponent'
            ]
        ]
    ]);

    $expected = [
        'data' => [
            'message' => 'Just a simple message'
        ],
        'type' => 'Tests\\Fixtures\\Components\\LivewireComponents\\WithSimpleLivewireComponent'
    ];

    //$this->actingAs(User::factory()->create());

    //\Filament\Facades\Filament::setCurrentPanel();

    \Pest\Livewire\livewire(EditPage::class, [
        'record' => $page->getKey()
    ])
    ->assertArrayValueAtIndexEquals($expected, 'data.content', 0);

    $this->assertStringContainsString('Just a simple message', $page->parsedContent);
    $this->assertStringContainsString('from livewire', $page->parsedContent);
})
->covers(\Titantwentyone\FilamentContentComponents\Contracts\CanRenderLivewire::class);

it('will render a complex livewire component', function () {

    $page = Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'message' => 'Just a simple message'
                ],
                'type' => 'Tests\\Fixtures\\Components\\LivewireComponents\\WithComplexLivewireComponent'
            ]
        ]
    ]);

    $expected = [
        'data' => [
            'message' => 'Just a simple message'
        ],
        'type' => 'Tests\\Fixtures\\Components\\LivewireComponents\\WithComplexLivewireComponent'
    ];

    \Pest\Livewire\livewire(EditPage::class, [
        'record' => $page->getKey()
    ])
        ->assertArrayValueAtIndexEquals($expected, 'data.content', 0);

    $this->assertStringContainsString('Just a simple message', $page->parsedContent);
    $this->assertStringContainsString('I am happy', $page->parsedContent);

})
->covers(\Titantwentyone\FilamentContentComponents\Contracts\CanRenderLivewire::class);

it('will output the livewire component', function () {

    $data = [
        'data' => [
            'message' => 'some message'
        ]
    ];

    $component = \Livewire\Livewire::mount('simple-livewire-component', $data['data']);

    $livewire_rendered = anonymizeLivewireComponent($component);
    $component_rendered = anonymizeLivewireComponent(\Tests\Fixtures\Components\LivewireComponents\WithSimpleLivewireComponent::processrender($data['data']));

    $this->assertEquals(
        $component_rendered,
        $livewire_rendered
    );
})
->covers(\Titantwentyone\FilamentContentComponents\Contracts\CanRenderLivewire::class);