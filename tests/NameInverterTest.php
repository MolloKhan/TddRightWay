<?php

namespace App\Tests;

use App\NameInverter;
use PHPUnit\Framework\TestCase;

class NameInverterTest extends TestCase
{
    private NameInverter $nameInverter;

    protected function setUp(): void
    {
        $this->nameInverter = new NameInverter();
    }

    public function testInvert_givenNull_returnEmptyString()
    {
        // Arrange
        $name = null;

        // Act
        $invertedName = $this->nameInverter->invert($name);

        // Assert
        self::assertEquals('', $invertedName);
    }

    public function testInvert_givenSimpleName_returnName()
    {
        $this->assertInvertedName('Diego', 'Diego');
    }

    private function assertInvertedName(string $name, string $invertedName): void
    {
        self::assertEquals($invertedName, $this->nameInverter->invert($name));
    }
}
