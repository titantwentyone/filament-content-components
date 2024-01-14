<?php

namespace Titantwentyone\FilamentContentComponents\Testing;

use Closure;
use Filament\Forms\Components\Field;
use Illuminate\Testing\Assert;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;
use Titantwentyone\FilamentContentComponents\Fields\ContentBuilder;

class AssertionsMixin
{
    public function assertContentBuilderFieldExists(): Closure
    {
        return function(string $builderName, string | Closure $formName = 'form'): static {

            $this->assertFormFieldExists($builderName);

            if ($formName instanceof Closure) {
                $checkFieldUsing = $formName;
                $formName = 'form';
            }

            $this->assertFormExists($formName);

            $form = $this->instance()->{$formName};

            $field = $form->getFlatFields(withHidden: true)[$builderName] ?? null;

            $livewireClass = $this->instance()::class;

            Assert::assertInstanceOf(
                ContentBuilder::class,
                $field,
                "Failed asserting that a field with the name [{$builderName}] on the form with the name [{$formName}] on the [{$livewireClass}] component is a ContentBuilder field."
            );

            return $this;
        };
    }

    public function assertComponentHasField(): Closure
    {
        return function(string $builderName, string $name, ?Closure $checkConfigurationUsing = null): static {

            $this->assertFormFieldExists($builderName);

        };
    }

    public function assertBuilderHasComponent(): Closure
    {
        return function(string $builderName, string $componentClassName, ?Closure $checkConfigurationUsing = null, string $formName = 'form'): static {

            $this->assertContentBuilderFieldExists($builderName, $formName);

            $form = $this->instance()->{$formName};

            $field = $form->getFlatFields(withHidden: true)[$builderName] ?? null;

            $components = collect(array_values($field->getState()));
            $components = $components->filter(fn($component) => $component['type'] == $componentClassName);

            Assert::assertGreaterThan(
                0,
                $components->count(),
                "The builder component {$builderName} does not have a component of type {$componentClassName}"
            );

            if($checkConfigurationUsing) {
                $components = $components->filter(fn($component) => $checkConfigurationUsing($component));
            }

            Assert::assertGreaterThan(
                0,
                $components->count(),
                "The builder component {$builderName} does not have a component of type {$componentClassName} with the given configuration"
            );

            return $this;
        };
    }
}