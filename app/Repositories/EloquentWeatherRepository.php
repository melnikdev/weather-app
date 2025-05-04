<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\WeatherData;
use App\Entities\Weather;
use App\Models\Weather as EloquentWeather;

class EloquentWeatherRepository implements WeatherRepositoryInterface
{
    public function create(WeatherData $weatherDTO): Weather
    {
        $eloquentWeather = EloquentWeather::query()->create([
            'country' => $weatherDTO->country,
            'city' => $weatherDTO->city,
            'temperature' => $weatherDTO->temperature,
            'condition' => $weatherDTO->condition,
            'humidity' => $weatherDTO->humidity,
            'wind_speed' => $weatherDTO->windSpeed,
            'last_updated' => $weatherDTO->lastUpdated,
        ]);

        return $this->toDomain($eloquentWeather);
    }

    private function toDomain(EloquentWeather $eloquentUser): Weather
    {
        return new Weather(
            $eloquentUser->id,
            $eloquentUser->country,
            $eloquentUser->city,
            $eloquentUser->temperature,
            $eloquentUser->condition,
            $eloquentUser->humidity,
            $eloquentUser->wind_speed,
            $eloquentUser->last_updated,
        );
    }
}
