<?php

namespace Tests;

use Closure;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\AssertionFailedError;

//@todo refactor into own package
class TestableLivewireMixin
{
    /**
     * example
     * ->assertArrayValueAtIndexEquals($expected, 'data.content', 0)
     */
    public function assertArrayValueAtIndexEquals() : Closure
    {
        return function($expected, ...$paths){

            $value = null;

            $full_path = [];

            foreach($paths as $path)
            {
                if(is_string($path))
                {
                    //$value = $value ? $this->get($paths[0][0]) : collect($value)->get($path);
                    $full_path = array_merge($full_path, explode(".", $path));
                }
                elseif(is_integer($path))
                {
                    try {
                        $keys = array_keys($this->get(implode(".", $full_path)));

                        $key = $keys[$path];
                        $full_path = array_merge($full_path, [$key]);
                        //$value = collect($value)->skip($path)->first();
                    } catch(\Throwable $e) {
                        throw new AssertionFailedError('The path given is incorrect');
                    }
                }
            }

            //$value = collect($this->get($paths[0][0]))->skip($paths[0][1])->first();

            $value = $this->get(implode(".", $full_path));

            Assert::assertEquals($expected, $value);
            return $this;
        };
    }
}