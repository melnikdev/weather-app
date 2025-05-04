<?php

declare(strict_types=1);

namespace App\DTO;

class WeatherData
{
    public function __construct(
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
