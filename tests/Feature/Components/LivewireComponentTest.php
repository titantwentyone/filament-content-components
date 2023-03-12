<?php

namespace Tests\Feature\Components;

use Filament\Forms\ComponentContainer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\ComponentConcerns\RendersLivewireComponents;
use Livewire\Livewire;
use Mockery\MockInterface;
use Tests\Fixtures\Components\LivewireComponents\WithSimpleLivewireComponent;
use Tests\Fixtures\Filament\Resources\PageResource\Pages\EditPage;
use Tests\Fixtures\Models\Page;
use Tests\TestCase;
use Titantwentyone\FilamentContentComponents\Concerns\HasContent;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderLivewire;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;
use Titantwentyone\FilamentContentComponents\Fields\ContentBuilder;

class LivewireComponentTest extends TestCase
{
    use RefreshDatabase;
    use RendersLivewireComponents;

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

    /**
     * @test
     */
    public function it_will_output_the_livewire_component()
    {
        $data = [
            'data' => [
                'message' => 'some message'
            ]
        ];

        $component = Livewire::mount('simple-livewire-component', $data);

        $livewire_rendered = $this->anonymizeLivewireComponent($component->html());
        $component_rendered = $this->anonymizeLivewireComponent(WithSimpleLivewireComponent::processrender($data['data']));

        $this->assertEquals(
            $component_rendered,
            $livewire_rendered
        );
    }

    /**
     * Replaces wire:id and wire:initial-data with anonymized values for id (in wire:id) and checksum (in wire:initial-data)
     * so that they can be used for comparisons when testing
     * @param $html string rendered livewire component
     * @return string anonymized livewire component
     */
    private function anonymizeLivewireComponent($html) : string
    {
        preg_match('/wire:id="([[:alnum:]]*?)"/', $html, $wire_id_match);
        $html = str_replace($wire_id_match[1], 'wire:id="testing"', $html);

        $html = preg_replace('/wire:id="([[:alnum:]]*?)"/', 'testing', $html);
        $initial_data_match = [];
        preg_match('/wire:initial-data="([[:print:]]*?)"/', $html, $initial_data_match);
        $initial_data_match = json_decode(html_entity_decode($initial_data_match[1]), true);
        $initial_data_match['serverMemo']['checksum'] = 'testing';
        $initial_data = "wire:initial-data=\"".htmlentities(json_encode($initial_data_match))."\"";
        return preg_replace('/wire:initial-data="([[:print:]]*)"/', $initial_data, $html);
    }
}