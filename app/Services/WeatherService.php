<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\WeatherData;
use App\Entities\Weather;
use App\Exceptions\InvalidWeatherException;
use App\Repositories\WeatherRepositoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

readonly class WeatherService
{
    public function __construct(
        private ClientInterface $client,
        private WeatherRepositoryInterface $repository,
        private string $apiKey,
        private string $url,
    ) {
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     * @throws InvalidWeatherException
     */
    public function getWeather(string $city): Weather
    {
        try {
            $weatherArray = $this->getWeatherByCity($city);
        } catch (\Exception $exception) {
            throw new InvalidWeatherException($exception->getMessage());
        }
        return $this->repository->create($weatherArray);
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    private function getWeatherByCity(string $city): WeatherData
    {
        $response = $this->client->request('GET', $this->url, [
            'query' => [
                'key' => $this->apiKey,
                'q' => $city
            ],
            'timeout' => 30,
        ]);
        $rawContents = $response->getBody()->getContents();

        $weatherArray = json_decode($rawContents, true, 512, JSON_THROW_ON_ERROR);

        return $this->toDTO($weatherArray);
    }

    private function toDTO(array $weatherArray): WeatherData
    {
        return new WeatherData(
            $weatherArray['location']['country'],
            $weatherArray['location']['name'],
            $weatherArray['current']['temp_c'],
            $weatherArray['current']['condition']['text'],
            $weatherArray['current']['humidity'],
            $weatherArray['current']['wind_kph'],
            $weatherArray['current']['last_updated'],
        );
    }
}