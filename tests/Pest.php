<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');
use Tests\Fixtures\Models\User;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class
)->in('Feature');

uses(
    \Tests\Feature2TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class
)->in('Feature2');

uses(
    \Tests\Feature3TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class
)->in('Feature3');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Replaces wire:id and wire:initial-data with anonymized values for id (in wire:id) and checksum (in wire:initial-data)
 * so that they can be used for comparisons when testing
 * @param $html string rendered livewire component
 * @return string anonymized livewire component
 */
function anonymizeLivewireComponent($html) : string
{
    preg_match('/wire:id="([[:alnum:]]*?)"/', $html, $wire_id_match);
    $html = str_replace($wire_id_match[1], 'wire:id="testing"', $html);

    $html = preg_replace('/wire:id="([[:alnum:]]*?)"/', 'testing', $html);
    $initial_data_match = [];
    preg_match('/wire:snapshot="([[:print:]]*?)"/', $html, $initial_data_match);
    $initial_data_match = json_decode(html_entity_decode($initial_data_match[1]), true);
    $initial_data_match['checksum'] = 'testing';
    $initial_data = "wire:snapshot=\"".htmlentities(json_encode($initial_data_match))."\"";
    return preg_replace('/wire:snapshot="([[:print:]]*)"/', $initial_data, $html);
    return $html;
}


