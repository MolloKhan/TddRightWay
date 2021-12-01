<?php

namespace App;

class WordWrapper
{
    public function wrap(string $s, int $width): string
    {
        if (strlen($s) > $width) {
            return str_replace(' ', "\n", $s);
        }
        
        return $s;
    }
}
