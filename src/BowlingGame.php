<?php

namespace App;

class BowlingGame
{
    private array $rolls = [];
    private int $currentRoll = 0;

    public function roll(int $pins)
    {
        $this->rolls[$this->currentRoll++] = $pins;
    }

    public function score(): int
    {
        $score = 0;
        $frameIndex = 0;
        for ($frame = 0; $frame < 10; $frame++) {
            // spare
            if ($this->rolls[$frameIndex] + $this->rolls[$frameIndex + 1] === 10) {
                $score += 10 + $this->rolls[$frameIndex + 2];
            } else {
                $score += $this->rolls[$frameIndex] + $this->rolls[$frameIndex + 1];
            }

            $frameIndex += 2;
        }

        return $score;
    }
}
