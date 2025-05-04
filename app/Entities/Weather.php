<?php

declare(strict_types=1);

namespace App\Entities;

class Weather
{
    public function __construct(
        public int $id,
        public string $country,
        public string $city,
        public float $temperature,
        public string $condition,
        public int $humidity,
        public float $windSpeed,
        public string $lastUpdated,
    ) {
    }
}
