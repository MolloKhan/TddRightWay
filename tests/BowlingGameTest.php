<?php

namespace App\Tests;

use App\BowlingGame;
use PHPUnit\Framework\TestCase;

class BowlingGameTest extends TestCase
{
    private BowlingGame $game;

    protected function setUp(): void
    {
        $this->game = new BowlingGame();
    }

    public function testGutterGame()
    {
        $this->rollMany(20, 0);

        self::assertEquals(0, $this->game->score());
    }

    /**
     * "Triangulation" Technique
     */
    public function testAllOnes()
    {
        $this->rollMany(20, 1);

        self::assertEquals(20, $this->game->score());
    }

    public function testOneSpare()
    {
        $this->rollSpare();
        $this->game->roll(3);
        $this->rollMany(17, 0);

        self::assertEquals(16, $this->game->score());
    }

    private function rollMany(int $n, int $pins): void
    {
        for ($i = 0; $i < $n; $i++) {
            $this->game->roll($pins);
        }
    }

    protected function rollSpare(): void
    {
        $this->game->roll(5);
        $this->game->roll(5);
    }
}
