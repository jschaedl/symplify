<?php

declare(strict_types=1);

namespace Symplify\PHP7_Sculpin\Tests\Utils;

use PHPUnit\Framework\TestCase;
use Symplify\PHP7_Sculpin\Utils\PathNormalizer;

final class PathNormalizerTest extends TestCase
{
    /**
     * @dataProvider provideDataForNormalize()
     */
    public function test(string $normalizedPath, string $path)
    {
        $this->assertSame($normalizedPath, PathNormalizer::normalize($path));
    }

    public function provideDataForNormalize() : array
    {
        return [
            ['dir-one'.DIRECTORY_SEPARATOR.'dir-two', 'dir-one\dir-two'],
            ['dir-one'.DIRECTORY_SEPARATOR.'dir-two', 'dir-one/dir-two'],
        ];
    }
}
