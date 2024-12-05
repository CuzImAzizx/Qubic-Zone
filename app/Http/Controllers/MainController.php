<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\City;
use App\Models\Size;
use App\Models\Unit;
use App\Models\unit_order;
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
    public function displayUnits($cityId, $branchId){
        $city = City::where('id', '=', $cityId)->first();
        $branch = Branch::where('id', '=', $branchId)->first();
        
        $availableUnits = Unit::where('branch_id', '=', $branchId)
        ->where('is_available', '=', true)
        ->get();
        $sizes = Size::get();

        return view('pages.rentingForm')
        ->with('branch', $branch)
        ->with('city', $city)
        ->with('availableUnits', $availableUnits)
        ->with('sizes', $sizes);

    }

    public function proccessOrder(Request $request){
        $cityId = $request->city_id;
        $branchId = $request->branch_id;
        $units = $request->sizes;
        $userId = $request->user_id;


        //Calculate the total price
        $totalPrice = 0;
        $allSizes = Size::get();
        foreach ($allSizes as $currentSize) {
            foreach ($units as $unitId => $quantity) {
                if($currentSize->id == $unitId){
                    $totalPrice += $currentSize->price_per_month * $quantity;
                }
            }
        }

        //TODO: Check if there's enough units to order

        //Change the availablility of the units for each size
        $allSmallUnits = Unit::where('size_id', '=', 1)
        ->where('branch_id', '=', $branchId)->get();

        $allMediumUnits = Unit::where('size_id', '=', 2)
        ->where('branch_id', '=', $branchId)->get();

        $allLargeUnits = Unit::where('size_id', '=', 3)
        ->where('branch_id', '=', $branchId)->get();

        $unitsIds = [];
        
        for($i = 0; $i < $units[1]; $i++){
            $allSmallUnits[$i]->is_available = false;
            $allSmallUnits[$i]->update();
            array_push($unitsIds, $allSmallUnits[$i]->id);
        }
        for($i = 0; $i < $units[2]; $i++){
            $allMediumUnits[$i]->is_available = false;
            $allMediumUnits[$i]->update();
            array_push($unitsIds, $allMediumUnits[$i]->id);

        }
        for($i = 0; $i < $units[3]; $i++){
            $allLargeUnits[$i]->is_available = false;
            $allLargeUnits[$i]->update();
            array_push($unitsIds, $allLargeUnits[$i]->id);
        }

        $palcedOrder = unit_order::create([
            //'user_id' => $userId,
            'branch_id' => $branchId,
            'units' => json_encode($unitsIds),
            'total_price' => $totalPrice,
        ]);
        return $palcedOrder;


        //


    }

}
