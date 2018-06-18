<?php declare(strict_types=1);

namespace Iter\Tests;

trait GeneratorTestTrait
{
    public function asGenerator(array $items) : \Generator
    {
        foreach ($items as $item) {
            yield $item;
        }
    }
}
