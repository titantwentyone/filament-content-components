<?php

namespace Tests\Feature\Testing;

use Livewire\Livewire;
use Orchestra\Testbench\Attributes\DefineEnvironment;
use PHPUnit\Framework\Attributes\Test;
use Tests\Concerns\HasInlineResourceFixture;
use Tests\Fixtures\Models\User;
use Titantwentyone\FilamentContentComponents\Fields\ContentBuilder;
use function Pest\Livewire\livewire;
use Tests\Fixtures\Filament\Resources\PageResource\Pages\CreatePage;

class AssertionsTest extends \Tests\TestCase
{
    use HasInlineResourceFixture;

    #[Test]
    public function it_will_assert_that_a_content_builder_field_exists()
    {
        $this->resourceClassForm([
            ContentBuilder::make('content')
        ]);

        Livewire::test($this->getCreateClass())
            ->assertContentBuilderFieldExists('content');

        $this->expectException('PHPUnit\Framework\ExpectationFailedException');
        $this->expectExceptionMessage("Failed asserting that a field with the name [content] exists on the form with the name [form] on the [".$this->getCreateClass()."] component.");

        $this->resourceClassForm([]);

        Livewire::test($this->getCreateClass())
            ->assertContentBuilderFieldExists('content');

        $this->resourceClassForm(fn() => [
            ContentBuilder::make('content')
        ]);

        Livewire::test($this->getCreateClass())
            ->assertContentBuilderFieldExists('content');
    }
}