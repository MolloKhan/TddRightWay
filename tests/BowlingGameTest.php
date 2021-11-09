<?php

namespace App\Tests;

use App\BowlingGame;
use PHPUnit\Framework\TestCase;

class BowlingGameTest extends TestCase
{
    public function testGutterGame()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(0);
        }

        self::assertEquals(0, $game->score());
    }

    /**
     * "Triangulation" Technique
     */
    public function testAllOnes()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(1);
        }

        self::assertEquals(20, $game->score());
    }
}
