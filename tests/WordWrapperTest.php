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
            'width includes a space' => ['x xx', 3, "x\nxx"],
            'width includes a space following by another word' => ['x xx x', 3, "x\nxx\nx"],
            'integration' => [
                'Welcome everybody to Symfony2021 this TDD workshop it\'s gonna be a blast',
                9,
                "Welcome\neverybody\nto\nSymfony20\n21 this\nTDD\nworkshop\nit's\ngonna be\na blast"
            ],
            'performance' => [
                $this->getWords(300),
                1,
                $this->getWords(300, true),
            ]
        ];
    }

    private function getWords(int $quantity, bool $useBreakLine = false): string
    {
        $word = 'a' . ($useBreakLine ? "\n" : ' ');

        return rtrim(str_repeat($word, $quantity));
    }
}
