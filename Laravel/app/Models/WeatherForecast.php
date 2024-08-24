<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherForecast extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_name',
        'weather_condition',
        'temperature',
        'humidity',
        'wind_speed',
    ];
}
