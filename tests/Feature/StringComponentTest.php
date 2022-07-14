<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\Fixtures\Models\User;
use Tests\TestCase;
use Tests\Fixtures\Filament\Resources\PageResource\Pages\EditPage;
use Tests\Fixtures\Models\Page;

class StringComponentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_handle_different_field_names_for_content()
    {
        $page = Page::create([
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
    }

    /**
     * @test
     */
    public function it_will_render_multiple_components()
    {
        $page = Page::create([
            'title' => 'A Test Page',
            'slug' => 'a-test-page',
            'text' => [
                [
                    'data' => [
                        'text' => 'Different field used'
                    ],
                    'type' => 'string-components.string-content-component-with-overridden-method'
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

        $this->assertEquals('Different field usedhello Jane', $page->parsedText);
    }

    /**
     * @test
     */
    public function it_will_handle_empty_content()
    {
        $page = Page::create([
            'title' => 'A Test Page',
            'slug' => 'a-test-page',
            'text' => []
        ]);

        $this->assertEquals('', $page->parsedText);
    }

    /**
     * @test
     */
    public function it_will_render_a_string_component()
    {
        $page = Page::create([
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
    }

    /**
     * @test
     */
    public function it_will_render_a_string_component_with_overridden_render_method()
    {
        $page = Page::create([
            'title' => 'A Test Page',
            'slug' => 'a-test-page',
            'text' => [
                [
                    'data' => [
                        'text' => 'hello there'
                    ],
                    'type' => 'string-components.string-content-component-with-overridden-method'
                ]
            ]
        ]);

        $this->assertEquals('hello there', $page->parsedText);
    }

    /**
     * @test
     */
    public function filament_correctly_populates_the_content_field()
    {
        $this->actingAs(User::factory()->create());

        $page = Page::create([
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

        Livewire::test(EditPage::class, [
            'record' => $page->getKey()
        ])
            ->assertArrayValueAtIndexEquals($expected, 'data.content', 0);
    }
}