<?php declare(strict_types=1);

namespace Iter\Tests\Examples;

use PHPUnit\Framework\TestCase;
use Iter\Iter;

final class VersionedUpdateFile extends TestCase
{
    //Preordered map
    private const MAP = [
        "1.0.0" => "BasicUpdateFile",
        "1.0.3" => "ImprovedUpdateFile",
        "2.0.0" => "BestUpdateFile",
    ];

    public function testFindRightVersion()
    {
        $currentVersion = "1.5.0";

        $nextBestVersion = Iter::from(self::MAP)
            ->takeWhile(function ($version, $_) use ($currentVersion) { return version_compare($version, $currentVersion, "<="); })
            ->last();

        $this->assertEquals("ImprovedUpdateFile", $nextBestVersion);
    }
}