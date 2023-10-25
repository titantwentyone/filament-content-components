<?php

it('will provide the correct label', function() {

    $baseline_content = [
        [
            "data" => [
                "message" => "a message"
            ],
            "type" => "Tests\\Fixtures\\Components\\LivewireComponents\\WithComplexLivewireComponent"
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
        ->assertFormFieldExists('content', function(\Titantwentyone\FilamentContentComponents\Fields\ContentBuilder $field) {
            return collect($field->getChildComponentContainers())->first()->getParentComponent()->getLabel() == "With Complex Livewire Component";
        });
});