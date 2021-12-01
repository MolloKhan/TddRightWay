<?php

namespace App\Tests;

use App\WordWrapper;
use PHPUnit\Framework\TestCase;

class WordWrapperTest extends TestCase
{
    public function testShouldWrap()
    {
        $wordWrapper = new WordWrapper();
        $result = $wordWrapper->wrap('word word', 4);

        self::assertEquals("word\nword", $result);
    }

    public function testShouldNotWrap()
    {
        $wordWrapper = new WordWrapper();
        $result = $wordWrapper->wrap('a word', 6);

        self::assertEquals("a word", $result);
    }

    public function testBreakLineAcrossWord()
    {
        $wordWrapper = new WordWrapper();
        $result = $wordWrapper->wrap('this is a test', 4);

        self::assertEquals("this\nis a\ntest", $result);
    }
}
