<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;

class WeatherForecastController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getWeather(Request $request)
    {
        $request->validate(['city' => 'required|string']);
        $weather = $this->weatherService->fetchWeatherData($request->city);

        if ($weather) {
            return response()->json($weather);
        }

        return response()->json(['error' => 'City not found'], 404);
    }
}