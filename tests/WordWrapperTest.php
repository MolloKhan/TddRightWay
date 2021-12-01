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
        ];
    }
}
