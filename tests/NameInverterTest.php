<?php

namespace App\Tests;

use App\NameInverter;
use PHPUnit\Framework\TestCase;

class NameInverterTest extends TestCase
{
    public function testInvert_givenNull_returnEmptyString()
    {
        // Arrange
        $name = null;

        // Act
        $nameInverter = new NameInverter();
        $invertedName = $nameInverter->invert($name);

        // Assert
        self::assertEquals('', $invertedName);
    }
}
