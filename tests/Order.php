<?php declare(strict_types=1);

namespace Iter\Tests;

use PHPUnit\Framework\TestCase;
use Iter\Functions;

final class Order extends TestCase
{
    use GeneratorTestTrait;

    public function testOrderDescendingArray()
    {
        $data = [1,3,5,4,2];
        $result = Functions::orderDescending($data);

        $this->assertEquals([5,4,3,2,1], Functions::toArray($result));
        // Make sure the rsort function didn't touch the original array
        $this->assertEquals([1,3,5,4,2], $data);
    }

    public function testOrderDescendingGenerator()
    {
        $result = Functions::orderDescending($this->asGenerator([1,3,5,4,2]));

        $this->assertEquals([5,4,3,2,1], Functions::toArray($result));
    }

    //TODO: add tests for ascending and custom
    //TODO: add tests that check that the keys are preserved.
}