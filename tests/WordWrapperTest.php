<?php

namespace App\Tests;

use App\WordWrapper;
use PHPUnit\Framework\TestCase;

class WordWrapperTest extends TestCase
{
    public function testShouldWrap()
    {
        $this->assertWrap('', 1, '');
    }

    private function assertWrap(string $s, int $width, string $expected)
    {
        $wordWrapper = new WordWrapper();
        $result = $wordWrapper->wrap($s, $width);

        self::assertEquals($expected, $result);
    }
}
