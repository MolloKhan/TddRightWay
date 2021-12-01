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

//        $breakPoint = strrpos(substr($s, 0, $width), ' ');
//        if ($breakPoint === false) {
//            $breakPoint = $width;
//        }

        return substr($s, 0, $width) . "\n" . substr($s, $width);
    }
}
