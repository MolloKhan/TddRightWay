<?php

namespace App\Tests;

use App\WordWrapper;
use PHPUnit\Framework\TestCase;

class WordWrapperTest extends TestCase
{
    public function testShouldWrap()
    {
        $wordWrapper = new WordWrapper();
        $result = $wordWrapper->wrap('', 1);

        self::assertEquals('', $result);
    }
}
