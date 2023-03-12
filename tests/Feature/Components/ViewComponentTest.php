<?php

namespace Tests\Feature\Components;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixtures\Components\ViewComponents\ViewContentComponent;
use Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenGetViewMethod;
use Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenMethod;
use Tests\Fixtures\Components\ViewComponents\ViewContentComponentWithOverriddenViewProperty;
use Tests\Fixtures\Models\Page;
use Tests\TestCase;

class ViewComponentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_will_render_a_view_component()
    {
        $page = Page::create([
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
    }

    /**
     * @test
     */
    public function it_will_render_a_view_component_with_overridden_render_method()
    {
        $page = Page::create([
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
    }

    /**
     * @test
     */
    public function it_will_render_a_view_component_with_overridden_view_property()
    {
        $page = Page::create([
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
    }

    /**
     * @test
     */
    public function it_will_render_a_view_component_with_overridden_get_view_method()
    {
        $page = Page::create([
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

        $page = Page::create([
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
    }

    /**
     * @test
     */
    public function it_will_output_the_view()
    {
        $data = [
            'text' => 'a short message'
        ];

        $this->assertEquals(
            view('view-components.view-content-component', ['data' => $data]),
            ViewContentComponent::processRender($data)
        );

        $data = [
            'happy' => 'yes'
        ];

        $this->assertEquals(
            view('view-components.happy', ['data' => $data]),
            ViewContentComponentWithOverriddenGetViewMethod::processRender($data)
        );

        $data = [
            'text' => 'a short message'
        ];

        $this->assertEquals(
            view('simple-text-component-different-view', ['differentdata' => $data]),
            ViewContentComponentWithOverriddenMethod::processRender($data)
        );

        $data = [
            'text' => 'another short message'
        ];

        $this->assertEquals(
            view('custom.view.path.my-component', ['data' => $data]),
            ViewContentComponentWithOverriddenViewProperty::processRender($data)
        );
    }
}