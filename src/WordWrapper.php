<?php

namespace App;

class WordWrapper
{
    public function wrap(string $s, int $width): string
    {
        return str_replace(' ', "\n", $s);
    }
}
