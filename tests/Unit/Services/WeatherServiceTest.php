<?php

use App\Entities\Weather;
use App\Repositories\WeatherRepositoryInterface;
use App\Services\WeatherService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

beforeEach(function () {
    $this->client = Mockery::mock(ClientInterface::class);
    $this->repository = Mockery::mock(WeatherRepositoryInterface::class);
    $this->service = new WeatherService($this->client, $this->repository, 'key', 'url');
});

test('get weather returns weather entity', function () {
    $city = 'Kyiv';
    $weatherData = [
        'location' => [
            'country' => 'Ukraine',
            'name' => 'Kyiv',
        ],
        'current' => [
            'temp_c' => 20.5,
            'condition' => [
                'text' => 'Sunny',
            ],
            'humidity' => 65,
            'wind_kph' => 15.2,
            'last_updated' => '2024-03-20 12:00',
        ],
    ];

    $response = new Response(
        200,
        [],
        json_encode($weatherData, JSON_THROW_ON_ERROR)
    );

    $this->client
        ->shouldReceive('request')
        ->once()
        ->andReturn($response);


    $weather = new Weather(1, 'Ukraine', 'Kyiv',
        20.5, 'Sunny', 20,
        12.4, '2024-03-20 12:00');

    $this->repository
        ->shouldReceive('create')
        ->once()
        ->andReturn($weather);

    $result = $this->service->getWeather($city);

    expect($result)->toBeInstanceOf(Weather::class);
});

test('get weather throws exception on invalid response', function () {
    $city = 'Kyiv';
    $invalidJson = '{invalid json}';

    $response = new Response(
        200,
        [],
        $invalidJson
    );

    $this->client
        ->shouldReceive('request')
        ->once()
        ->andReturn($response);

    expect(fn() => $this->service->getWeather($city))
        ->toThrow(JsonException::class);
});
