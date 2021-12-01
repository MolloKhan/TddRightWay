<?php

namespace App;

class WordWrapper
{
    private $breakPoint = false;

    public function wrap(string $s, int $width): string
    {
        $r = '';
        $newString = $s;

        do {
            $r .= $this->cut($newString, $width);
            $tail = trim(substr($newString, $this->breakPoint));
            if ($tail) {
                $r .= "\n";
            }

            $newString = $tail;
        } while($tail);

        return $r;
    }

    private function cut(string $s, int $width): string
    {
        $this->breakPoint = $width;

        if (!$s) {
            return '';
        }

        if (strlen($s) <= $width) {
            return $s;
        }

        $this->breakPoint = strrpos(substr($s, 0, $width), ' ');
        if ($this->breakPoint === false) {
            $this->breakPoint = $width;
        }

        return substr($s, 0, $this->breakPoint);
    }
}
