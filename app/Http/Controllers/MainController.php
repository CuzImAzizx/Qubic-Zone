<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\City;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function displayHomePage(){
        return view('pages.home');
    }

    public function displayCities(){
        // Get all the cites coverd
        $cities = City::get();

        return view('pages.rent')->with('cities', $cities); 
    }
    public function displayBranches($cityId){
        //return $city;
        $branches = Branch::where('city_id', '=', $cityId)->get();
        $city = City::where('id', '=', $cityId)->first();
        return view('pages.branches')
        ->with('branches', $branches)
        ->with('city', $city); 
    }
    public function displayRentingForm($cityId, $branchId){
        $city = City::where('id', '=', $cityId)->first();
        $branch = Branch::where('id', '=', $branchId)->first();

        return view('pages.rentingForm')
        ->with('branch', $branch)
        ->with('city', $city); 

    }
}
