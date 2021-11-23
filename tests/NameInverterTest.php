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

    public function testInvert_givenSimpleNameWithSpaces_returnNameWithoutSpaces()
    {
        $this->assertInvertedName('  Diego  ', 'Diego');
    }

    public function testInvert_givenFirstLast_returnLastFirst()
    {
        $this->assertInvertedName('Diego Aguiar', 'Aguiar, Diego');
    }
    
    public function testInvert_givenFirstLastWithSpaces_returnLastFirstWithoutSpaces()
    {
        $this->assertInvertedName('  Diego  Aguiar  ', 'Aguiar, Diego');
    }

    public function testInvert_ignoreHonorifics()
    {
        $this->assertInvertedName('Mr. Diego Aguiar', 'Aguiar, Diego');
        $this->assertInvertedName('Mrs. Diego Aguiar', 'Aguiar, Diego');
        $this->assertInvertedName('Ms. Diego Aguiar', 'Aguiar, Diego');
        $this->assertInvertedName('mr Diego Aguiar', 'Aguiar, Diego');
    }

    public function testInvert_postNominals_stayAtEnd()
    {
        $this->assertInvertedName('Diego Aguiar BS.', 'Aguiar, Diego BS.');
        $this->assertInvertedName('Diego Aguiar BS. Phd.', 'Aguiar, Diego BS. Phd.');
    }
    
    private function assertInvertedName(string $name, string $invertedName): void
    {
        self::assertEquals($invertedName, $this->nameInverter->invert($name));
    }
}
