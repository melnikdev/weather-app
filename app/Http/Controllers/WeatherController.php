<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function __construct(protected WeatherService $weatherService)
    {
    }

    public function __invoke(string $city): View
    {
        $weather = Cache::remember($city, 60, function () use ($city) {
            return $this->weatherService->getWeather($city);
        });

        return view('weather', ['weather' => $weather]);
    }
}
