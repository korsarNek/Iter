<?php declare(strict_types=1);

namespace Iter\Tests;

use PHPUnit\Framework\TestCase;
use Iter\Functions;

final class ConcatReverseFlatten extends TestCase
{
    use GeneratorTestTrait;

    public function testConcatArrayArray()
    {
        $result = Functions::concat([1,2,3], [4,5]);

        $this->assertEquals([1,2,3,4,5], Functions::toArray($result));
    }

    public function testConcatGeneratorArray()
    {
        $result = Functions::concat($this->asGenerator([1,2,3]), [4,5]);

        $this->assertEquals([1,2,3,4,5], Functions::toArray($result));
    }

    public function testConcatMore()
    {
        $result = Functions::concat([1,2,3], $this->asGenerator([4,5]), ["test",-1], $this->asGenerator([null,4]));

        $this->assertEquals([1,2,3,4,5,"test",-1,null,4], Functions::toArray($result));
    }

    public function testConcatNestedArray()
    {
        $result = Functions::concat([1,2,3], [[4,5]]);

        $this->assertEquals([1,2,3,[4,5]], Functions::toArray($result));
    }

    public function testFlatten()
    {
        $result = Functions::flatten([
            [1,2,3],
            "test",
            [2,4,0],
            [[3,0]]
        ]);

        $this->assertEquals([1,2,3,"test",2,4,0,3,0], Functions::toArray($result));
    }

    public function testReverseArray()
    {

    }

    public function testReverseGenerator()
    {
        
    }
}
