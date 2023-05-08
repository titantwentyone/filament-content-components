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

    \Pest\Livewire\livewire(EditPage::class, [
        'record' => $page->getKey()
    ])
        ->assertArrayValueAtIndexEquals($expected, 'data.content', 0);

    $this->assertStringContainsString('Just a simple message', $page->parsedContent);
    $this->assertStringContainsString('from livewire', $page->parsedContent);
});

it('will render a complex livewire component', function () {

    $page = Page::create([
        'title' => 'A Test Page',
        'slug' => 'a-test-page',
        'content' => [
            [
                'data' => [
                    'message' => 'Just a simple message'
                ],
                'type' => 'livewire-components.with-complex-livewire-component'
            ]
        ]
    ]);

    $expected = [
        'data' => [
            'message' => 'Just a simple message'
        ],
        'type' => 'livewire-components.with-complex-livewire-component'
    ];

    \Pest\Livewire\livewire(EditPage::class, [
        'record' => $page->getKey()
    ])
        ->assertArrayValueAtIndexEquals($expected, 'data.content', 0);

    $this->assertStringContainsString('Just a simple message', $page->parsedContent);
    $this->assertStringContainsString('I am happy', $page->parsedContent);

});

it('will output the livewire component', function () {

    $data = [
        'data' => [
            'message' => 'some message'
        ]
    ];

    $component = \Livewire\Livewire::mount('simple-livewire-component', $data);

    $livewire_rendered = anonymizeLivewireComponent($component->html());
    $component_rendered = anonymizeLivewireComponent(\Tests\Fixtures\Components\LivewireComponents\WithSimpleLivewireComponent::processrender($data['data']));

    $this->assertEquals(
        $component_rendered,
        $livewire_rendered
    );
});