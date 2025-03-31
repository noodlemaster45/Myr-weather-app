<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;
use App\Models\City;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class weatherController extends Controller
{
    public function index(Request $request){
        $city = $request->input('city','Ho Chi Minh City');
        $apiKey = env('OPENWEATHERMAP_API_KEY');
        $cities_list = City::pluck('name');
        try {
            $client = new Client();
            
            $weatherResponse = Cache::remember("weather_{$city}",now()->addMinutes(5),function() use ($city, $apiKey, $client){
                Log::info("Cached weather: $city");
                $weather = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";
                return json_decode($client->get($weather)->getBody(), true);

            });
            $forecastResponse = Cache::remember("forecast_{$city}",now()->addMinutes(5),function () use ($city, $apiKey, $client){
                Log::info("Cached forecast: $city");
                $forecast = "https://api.openweathermap.org/data/2.5/forecast?q=$city&appid=$apiKey&units=metric";
                    return json_decode($client->get($forecast)->getBody(), true);

            });
            return view('weather', ['weatherData' => $weatherResponse,'forecastData' => $forecastResponse,'oldInput'=>$city,'cities_list'=>$cities_list]);
        } catch (\Exception $e) {
            return view('api_error', ['error' => $e->getMessage()]);
        }
    }
}
