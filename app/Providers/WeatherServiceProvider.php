<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\EloquentWeatherRepository;
use App\Services\WeatherService;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(WeatherService::class, function () {
            return new WeatherService(
                new Client(),
                new EloquentWeatherRepository(),
                config('services.weather.api_key'),
                config('services.weather.api_url'));
        });
    }

    public function provides(): array
    {
        return [WeatherService::class];
    }
}
