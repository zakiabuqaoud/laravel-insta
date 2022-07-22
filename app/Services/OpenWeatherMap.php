<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenWeatherMap
{

    protected $key;

    protected $baseUrl = 'https://api.openweathermap.org/data/2.5';

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function currentWeather($city)
    {
        $response = Http::baseUrl($this->baseUrl)
            //->asForm() // Send as url-encoded-from
            ->withHeaders([
                //'Authorization' => 'Bearer tokensdfssdsdasdad',
                'x-api-key' => $this->key,
            ])
            //->withToken($token)
            ->get('weather', [
                'q' => $city,
                'appid' => $this->key,
                'units' => 'metric',
                'lang' => 'ar',
            ]);

        return $response->json();
    }
}