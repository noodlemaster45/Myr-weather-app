<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;

class weatherController extends Controller
{
    public function index(Request $request){
        $city = $request->input('city','Ho Chi Minh City');
        $apiKey = env('OPENWEATHERMAP_API_KEY');
        $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";
        try {
           
            $client = new Client();
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            return view('weather', ['weatherData' => $data,'oldInput'=>$city]);
        } catch (\Exception $e) {
            // Handle any errors that occur during the API request
            return view('api_error', ['error' => $e->getMessage()]);
        }
    }
}
