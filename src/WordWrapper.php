<?php

namespace App;

class WordWrapper
{
    public function wrap(string $s, int $width): string
    {
        if (!$s) {
            return '';
        }
        
        if (strlen($s) <= $width) {
            return $s;
        }

        return substr($s, 0, $width) . "\n" . $this->wrap(substr($s, $width), $width);
    }
}
