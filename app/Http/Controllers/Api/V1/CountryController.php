<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function getCountries() {
        $apiUrl = config('app.countries');
    
        // Usar cURL o Guzzle para hacer la solicitud a la API
        $client = new \GuzzleHttp\Client();
        $response = $client->get($apiUrl);
        $countries = json_decode($response->getBody(), true);
    
        return response()->json($countries);
    }
}
