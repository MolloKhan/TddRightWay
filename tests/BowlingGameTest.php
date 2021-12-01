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

    private function rollMany(int $n, int $pins): void
    {
        for ($i = 0; $i < $n; $i++) {
            $this->game->roll($pins);
        }
    }
}
