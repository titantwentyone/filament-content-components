<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\Fixtures\Filament\Resources\PageResource\Pages\EditPage;
use Tests\Fixtures\Models\Page;
use Tests\TestCase;

class LivewireComponentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_will_render_a_simple_livewire_component()
    {
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

        Livewire::test(EditPage::class, [
                'record' => $page->getKey()
            ])
            ->assertArrayValueAtIndexEquals($expected, 'data.content', 0);

        $this->assertStringContainsString('Just a simple message', $page->parsedContent);
        $this->assertStringContainsString('from livewire', $page->parsedContent);
    }

    /**
     * @test
     */
    public function it_will_render_a_complex_livewire_component()
    {
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

        Livewire::test(EditPage::class, [
            'record' => $page->getKey()
        ])
            ->assertArrayValueAtIndexEquals($expected, 'data.content', 0);

        $this->assertStringContainsString('Just a simple message', $page->parsedContent);
        $this->assertStringContainsString('I am happy', $page->parsedContent);
    }
}