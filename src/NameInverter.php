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

        $postNominals = '';
        if (count($nameParts) > 2) {
            $postNominals = $nameParts[2];
        }

        return trim(sprintf('%s, %s %s', $nameParts[1], $nameParts[0], $postNominals));
    }

    private function isHonorific(string $word): bool
    {
        return preg_match('/mr|mrs|ms/', str_replace('.', '', strtolower($word)));
    }
}
