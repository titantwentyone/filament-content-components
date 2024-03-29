<?php

declare(strict_types=1);

namespace Pest\Factories\Annotations;

use Pest\Contracts\AddsAnnotations;
use Pest\Factories\Testbench\Environment as EnvironmentFactory;
use Pest\Factories\TestCaseMethodFactory;

/**
 * @internal
 */
final class Environment implements AddsAnnotations
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(TestCaseMethodFactory $method, array $annotations): array
    {
        if (($method->environment[0] ?? null) instanceof EnvironmentFactory) {
            $annotations[] = "@define-env define_env_{$method->environment[0]->name}";
        }

        return $annotations;
    }
}