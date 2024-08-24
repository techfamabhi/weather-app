import React, { useState } from 'react';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

const Weather = () => {
    const [city, setCity] = useState('');
    const [weatherData, setWeatherData] = useState(null);
    const [error, setError] = useState('');

    const getWeather = async () => {
        // Check if the city input is empty
        if (!city.trim()) {
            toast.error('Please enter a city name');
            return;
        }

        try {
            const response = await axios.get(`https://weatherapp.gayatriinfotech.in/api/weather`, {
                params: { city }
            });
            setWeatherData(response.data);
            setError('');
        } catch (err) {
            // Handle errors and show a toast notification
            toast.error('City not found ');
            setWeatherData(null);
            setError('');
        }
    };

    return (
        <div className="container">
            <ToastContainer />
            <h1 className="my-4">Weather Forecast</h1>
            <div className="row mb-4">
                <div className="col-md-8">
                    <input
                        type="text"
                        value={city}
                        onChange={(e) => setCity(e.target.value)}
                        placeholder="Enter city name"
                        className="form-control"
                    />
                </div>
                <div className="col-md-4">
                    <button onClick={getWeather} className="btn btn-primary w-100">Get Weather</button>
                </div>
            </div>

            {error && <p className="text-danger">{error}</p>}

            {weatherData && (
                <div className="row">
                    <div className="col-md-3 mb-3">
                        <div className="card">
                            <div className="card-header"><b>Weather</b></div>
                            <div className="card-body">
                                <p className="card-text"><b>Condition</b>: {weatherData.weather.description}</p>
                                <p className="card-text"><b>Main</b>: {weatherData.weather.main}</p>
                                <img src={`https://openweathermap.org/img/wn/${weatherData.weather.icon}@2x.png`} alt="Weather Icon" />
                            </div>
                        </div>
                    </div>
                    <div className="col-md-3 mb-3">
                        <div className="card">
                            <div className="card-header"><b>Main</b></div>
                            <div className="card-body">
                                <p className="card-text"><b>Temperature:</b> {weatherData.main.temperature}°C</p>
                                <p className="card-text"><b>Feels Like:</b> {weatherData.main.feels_like}°C</p>
                                <p className="card-text"><b>Humidity:</b> {weatherData.main.humidity}%</p>
                                <p className="card-text"><b>Pressure:</b> {weatherData.main.pressure} hPa</p>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-3 mb-3">
                        <div className="card">
                            <div className="card-header"><b>Wind</b></div>
                            <div className="card-body">
                                <p className="card-text"><b>Wind Speed:</b> {weatherData.wind.speed} m/s</p>
                                <p className="card-text"><b>Direction: </b>{weatherData.wind.degree}°</p>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-3 mb-3">
                        <div className="card">
                            <div className="card-header"><b>Rain</b></div>
                            <div className="card-body">
                                <p className="card-text"><b>Rain:</b> {weatherData.rain || 'N/A'} mm</p>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default Weather;
