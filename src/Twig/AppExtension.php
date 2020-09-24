<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    protected $propertyTypeOptions = [
        "D" => "Detached",
        "F" => "Flat",
        "S" => "Semi Detached",
        "T" => "Terraced",
        "O" => "Other",
    ];

    protected $tenureOptions = [
        "F" => "Freehold",
        "L" => "Leasehold",
    ];

    public function getFilters() : array
    {
        return [
            new TwigFilter('format_property_type', [$this, 'formatPropertyType']),
            new TwigFilter('format_tenure', [$this, 'formatTenure']),
        ];
    }

    public function formatPropertyType(string $propertyType) : string
    {
        if (empty($this->propertyTypeOptions[$propertyType])) {
            return $propertyType;
        }

        return $this->propertyTypeOptions[$propertyType];
    }

    public function formatTenure(string $tenure) : string
    {
        if (empty($this->tenureOptions[$tenure])) {
            return $tenure;
        }

        return $this->tenureOptions[$tenure];
    }
}