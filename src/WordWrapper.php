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

        $breakPoint = strrpos($s, ' ');
        if ($breakPoint === false) {
            $breakPoint = $width;
        }

        return substr($s, 0, $breakPoint) . "\n" . $this->wrap(trim(substr($s, $breakPoint)), $width);
    }
}
