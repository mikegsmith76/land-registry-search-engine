<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters() : array
    {
        return [
            new TwigFilter('format_tenure', [$this, 'formatTenure']),
        ];
    }

    public function formatTenure(string $tenure) : string
    {
        $tenureOptions = [
            "F" => "Freehold",
            "L" => "Leasehold",
        ];

        if (empty($tenureOptions[$tenure])) {
            return $tenure;
        }

        return $tenureOptions[$tenure];
    }
}