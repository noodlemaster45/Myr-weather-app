<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;
use App\Models\City;
use GuzzleHttp\Client;

class weatherController extends Controller
{
    public function index(Request $request){
        $city = $request->input('city','Ho Chi Minh City');
        $apiKey = env('OPENWEATHERMAP_API_KEY');
        $cities_list = City::pluck('name');
        $tempMode = $request->input('tempMode',"metric");
        $weather = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";
        $forecast = "https://api.openweathermap.org/data/2.5/forecast?q=$city&appid=$apiKey";
        try {
           
            $client = new Client();
            $weatherResponse = $client->get($weather);
            $forecastResponse = $client->get($forecast);
            $weatherData = json_decode($weatherResponse->getBody(), true);
            $forecastData = json_decode($forecastResponse->getBody(), true);
            return view('weather', ['weatherData' => $weatherData,'forecastData' => $forecastData,'oldInput'=>$city,'cities_list'=>$cities_list,'temp' =>$tempMode]);
        } catch (\Exception $e) {
            return view('api_error', ['error' => $e->getMessage()]);
        }
    }
}
