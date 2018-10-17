<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CountriesController extends Controller
{
    public function index(Request $request){
        $json = json_encode(file_get_contents("https://restcountries.eu/rest/v2/region/Africa"), true);
        return response()->json($json);
    }
}
