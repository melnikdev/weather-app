<?php

namespace App\Repositories;

use App\DTO\WeatherData;
use App\Entities\Weather;

interface WeatherRepositoryInterface
{
    public function create(WeatherData $weatherDTO): Weather;
}