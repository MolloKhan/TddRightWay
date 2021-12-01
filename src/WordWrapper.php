<?php

namespace App;

class WordWrapper
{
    public function wrap(string $s, int $width): string
    {
        $r = '';
        $newString = $s;

        do {
            $r .= $this->cut($newString, $width);
            $tail = trim(substr($newString, $width));
            if ($tail) {
                $r .= "\n";
            }

            $newString = $tail;
        } while($tail);

        return $r;
    }

    private function cut(string $s, int $width): string
    {
        if (!$s) {
            return '';
        }

        if (strlen($s) <= $width) {
            return $s;
        }

        return substr($s, 0, $width);
    }

    public function wrapOld(string $s, int $width): string
    {
        if (!$s) {
            return '';
        }

        if (strlen($s) <= $width) {
            return $s;
        }

        $breakPoint = strrpos(substr($s, 0, $width), ' ');
        if ($breakPoint === false) {
            $breakPoint = $width;
        }

        return substr($s, 0, $width) . "\n" . substr($s, $width);
    }
}
