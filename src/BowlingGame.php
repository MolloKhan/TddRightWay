<?php

namespace App;

class BowlingGame
{
    private int $score = 0;

    public function roll(int $pins)
    {
        $this->score += $pins;
    }

    public function score(): int
    {
        // "fake it till you make it" technique
        return $this->score;
    }
}
