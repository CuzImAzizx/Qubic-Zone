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


        //Change the availablility of the units for each size
        $allSmallAvailableUnits = Unit::where('size_id', '=', 1)
        ->where('branch_id', '=', $branchId)
        ->where('is_available', '=', true)->get();

        $allMediumAvailableUnits = Unit::where('size_id', '=', 2)
        ->where('branch_id', '=', $branchId)
        ->where('is_available', '=', true)->get();

        $allLargeAvailableUnits = Unit::where('size_id', '=', 3)
        ->where('branch_id', '=', $branchId)
        ->where('is_available', '=', true)->get();

        $unitsIds = [];
        for($i = 1; $i <= $units[1]; $i++){
            $allSmallAvailableUnits[$i]->is_available = false;
            $allSmallAvailableUnits[$i]->update();
            array_push($unitsIds, $allSmallAvailableUnits[$i]->id);
        }
        for($i = 1; $i <= $units[2]; $i++){
            $allMediumAvailableUnits[$i]->is_available = false;
            $allMediumAvailableUnits[$i]->update();
            array_push($unitsIds, $allMediumAvailableUnits[$i]->id);

        }
        for($i = 1; $i <= $units[3]; $i++){
            $allLargeAvailableUnits[$i]->is_available = false;
            $allLargeAvailableUnits[$i]->update();
            array_push($unitsIds, $allLargeAvailableUnits[$i]->id);
        }

        $placedOrder = unit_order::create([
            'user_id' => $userId,
            'branch_id' => $branchId,
            'units' => json_encode($unitsIds),
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);
        return view('pages.confirmation')
        ->with('placedOrder', $placedOrder);
    }

    public function viewUserProfile(){
        //return auth()->user();
        return view('pages.profile');
    }

}
