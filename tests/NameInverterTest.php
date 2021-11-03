<?php

namespace App\Tests;

use App\NameInverter;
use PHPUnit\Framework\TestCase;

class NameInverterTest extends TestCase
{
    public function testInvert_givenNull_returnEmptyString()
    {
        $name = null;

        $nameInverter = new NameInverter();
        $invertedName = $nameInverter->invert($name);

        self::assertEquals('', $invertedName);
    }
    
    public function testInvert_givenSimpleName_returnName()
    {
        $name = 'Diego';

        $nameInverter = new NameInverter();
        $invertedName = $nameInverter->invert($name);
        
        self::assertEquals('Diego', $invertedName);
    }
}
