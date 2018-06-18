<?php declare(strict_types=1);

namespace Iter\Tests;

use PHPUnit\Framework\TestCase;
use Iter\Functions;

final class SkipTakeFilter extends TestCase
{
    //TODO: add tests that check that the keys got preserved
    public function testTakeWhile()
    {
        $result = Functions::takeWhile([1,2,3,4,0], function ($_, $number) { return $number <= 3; });

        $this->assertEquals([1,2,3], Functions::toArray($result));
    }

    public function testTake()
    {
        $result = Functions::take([1,2,3,4,0], 3);

        $this->assertEquals([1,2,3], Functions::toArray($result));
    }

    public function testTakeWithPartialForeach()
    {
        $data = [1,2,3,4,0];

        // Use a partial foreach that advances the array pointer.
        // The behavior of the foreach loop changed in PHP 7 so that it doesn't use the array pointer anymore.
        foreach ($data as $key => $item) {
            if ($key == 2) {
                break;
            }
        }

        $result = Functions::take($data, 3);

        $this->assertEquals([1,2,3], Functions::toArray($result));
    }

    public function testTakeWithManualArrayPointer()
    {
        $data = [1,2,3,4,0];

        // Make sure we don't use the array pointer in the take function.
        next($data);

        $result = Functions::take($data, 3);

        $this->assertEquals([1,2,3], Functions::toArray($result));
    }

    public function testSkipWhile()
    {
        $result = Functions::skipWhile([1,2,3,4,0], function ($_, $number) { return $number <= 3; });

        $this->assertEquals([4,0], Functions::toArray($result));
    }

    public function testSkipWhileMultiple()
    {
        $result = Functions::skipWhile([1,2,3,4,0], function ($_, $number) { return $number < 3; });
        $result = Functions::skipWhile($result, function ($_, $number) { return $number == 3; });

        $this->assertEquals([4,0], Functions::toArray($result));
    }

    public function testSkip()
    {
        $result = Functions::skip([1,2,3,4,0], 3);

        $this->assertEquals([4,0], Functions::toArray($result));
    }

    public function testSkipMultiple()
    {
        $result = Functions::skip([1,2,3,4,0], 2);
        $result = Functions::skip($result, 1);

        $this->assertEquals([4,0], Functions::toArray($result));
    }

    public function testWhere()
    {
        $result = Functions::where([1,2,3,4,0], function ($_, $number) { return $number < 3; });

        $this->assertEquals([1,2,0], Functions::toArray($result));
    }
}