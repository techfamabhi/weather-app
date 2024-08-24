<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherForecastController;

// Apply the 'cors' middleware
Route::get('/weather', [WeatherForecastController::class, 'getWeather'])->middleware('cors');