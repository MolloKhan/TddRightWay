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
}
