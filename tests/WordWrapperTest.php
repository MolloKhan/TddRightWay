<?php

namespace App\Tests;

use App\WordWrapper;
use PHPUnit\Framework\TestCase;

class WordWrapperTest extends TestCase
{
    public function testShouldWrap()
    {
        $this->assertWrap('', 1, '');
        $this->assertWrap('x', 1, 'x');
    }

    private function assertWrap(string $s, int $width, string $expected)
    {
        $wordWrapper = new WordWrapper();

        self::assertEquals($expected, $wordWrapper->wrap($s, $width));
    }
}
