<?php

namespace App\Http\Controllers;

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
        $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";
        try {
           
            $client = new Client();
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);
            return view('weather', ['weatherData' => $data,'oldInput'=>$city,'cities_list'=>$cities_list,'temp' =>$tempMode]);
        } catch (\Exception $e) {
            // Handle any errors that occur during the API request
            return view('api_error', ['error' => $e->getMessage()]);
        }
    }
}
