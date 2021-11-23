<?php

namespace App\Tests;

use App\WordWrapper;
use PHPUnit\Framework\TestCase;

class WordWrapperTest extends TestCase
{
    /**
     * @dataProvider shouldWrapProvider
     */
    public function testShouldWrap(string $s, int $width, string $expected)
    {
        $wordWrapper = new WordWrapper();

        self::assertEquals($expected, $wordWrapper->wrap($s, $width));
    }

    public function shouldWrapProvider(): iterable
    {
        return [
            'empty case' => ['', 1, ''],
            'one word' => ['x', 1, 'x'],
            'break word' => ['xx', 1, "x\nx"],
            'one word multiple break lines' => ['xxx', 1, "x\nx\nx"],
            'space after break line' => ['x x', 1, "x\nx"],
            'width includes a space' => ['x xx', 3, "x\nxx"]
        ];
    }
}
