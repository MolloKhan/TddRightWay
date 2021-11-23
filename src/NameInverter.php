<?php

namespace App;

class NameInverter
{
    public function invert(?string $name): string
    {
        if (!$name) {
            return '';
        }

        return $this->formatName(
            $this->removeHonorifics(
                $this->splitBySpaces($name)
            )
        );
    }

    private function splitBySpaces(string $name): array
    {
        return preg_split('/\s+/', trim($name));
    }

    private function removeHonorifics(array $nameParts): array
    {
        if (count($nameParts) > 1 && $this->isHonorific($nameParts[0])) {
            array_shift($nameParts);
        }

        return $nameParts;
    }

    private function isHonorific(string $word): bool
    {
        return preg_match('/mr|mrs|ms/', str_replace('.', '', strtolower($word)));
    }

    private function formatName(array $nameParts): string
    {
        if (count($nameParts) === 1) {
            return $nameParts[0];
        }

        return $this->formatNameWithPostNominals($nameParts);
    }

    private function formatNameWithPostNominals(array $nameParts): string
    {
        return trim(sprintf('%s, %s %s',
            $nameParts[1],
            $nameParts[0],
            $this->getPostNominals($nameParts)
        ));
    }

    private function getPostNominals(array $nameParts): string
    {
        $postNominals = array_slice($nameParts, 2);

        return implode(' ', $postNominals);
    }
}
