<?php

namespace App;

class NameInverter
{
    public function invert(?string $name): string
    {
        if (!$name) {
            return '';
        }

        $nameParts = preg_split('/\s+/', trim($name));

        if (count($nameParts) > 1 && $this->isHonorific($nameParts[0])) {
            array_shift($nameParts);
        }

        if (count($nameParts) === 1) {
            return $nameParts[0];
        }

        return sprintf('%s, %s', $nameParts[1], $nameParts[0]);
    }

    private function isHonorific(string $word): bool
    {
        return preg_match('/mr|mrs|ms/', str_replace('.', '', strtolower($word)));
    }
}
