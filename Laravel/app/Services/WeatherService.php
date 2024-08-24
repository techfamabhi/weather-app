<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\WeatherForecast;

class WeatherService
{
    protected $apiKey = '53e6d54f1382495817c433908e2c06b7'; 

    public function fetchWeatherData($city)
    {
        try {
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => $city,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ]);
    
            if ($response->successful()) {
                $data = $this->formatWeatherData($response->json());
                $this->storeWeatherData($data['storage_data']); // Store the data using storage_data
                return $data['formatted_data'];
            }
    
            return null;
    
        } catch (\Exception $e) {
            \Log::error('Exception:', ['message' => $e->getMessage()]);
            return null;
        }
    }

    protected function formatWeatherData($data)
{
    $formattedData = [
        'city' => $data['name'],
        'weather' => [
            'main' => $data['weather'][0]['main'],
            'description' => $data['weather'][0]['description'],
            'icon' => $data['weather'][0]['icon'],
        ],
        'main' => [
            'temperature' => $data['main']['temp'],
            'feels_like' => $data['main']['feels_like'],
            'humidity' => $data['main']['humidity'],
            'pressure' => $data['main']['pressure'],
        ],
        'wind' => [
            'speed' => $data['wind']['speed'],
            'degree' => $data['wind']['deg'],
        ],
        'rain' => isset($data['rain']) ? $data['rain']['1h'] : 0, // Rain in the last hour
        'base' => $data['base'],
    ];

    // Extract the specific fields for storage
    $storageData = [
        'city_name' => $data['name'],
        'weather_condition' => $data['weather'][0]['description'],
        'temperature' => $data['main']['temp'],
        'humidity' => $data['main']['humidity'],
        'wind_speed' => $data['wind']['speed'],
    ];

    return [
        'formatted_data' => $formattedData,
        'storage_data' => $storageData,
    ];
}


    
protected function storeWeatherData($data)
{
    return WeatherForecast::create($data);
}
}