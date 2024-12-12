<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\City;
use App\Models\Plan;
use App\Models\Size;
use App\Models\Unit;
use App\Models\unit_order;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function displayHomePage(){
        return view('pages.home');
    }

    public function displayServices(){
        return view('pages.services');
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

    public function viewAllBranches(){
        $cities = City::all();
        return view('pages.allBranches')->with('cities', $cities);
    }

    public function displayUnits($cityId, $branchId){
        $city = City::where('id', '=', $cityId)->first();
        $branch = Branch::where('id', '=', $branchId)->first();
        
        $availableUnits = Unit::where('branch_id', '=', $branchId)
        ->where('is_available', '=', true)
        ->where('type', '=', 'normal')
        ->get();
        $sizes = Size::get();

        return view('pages.rentingForm')
        ->with('branch', $branch)
        ->with('city', $city)
        ->with('availableUnits', $availableUnits)
        ->with('sizes', $sizes);

    }

    public function displayRefrigeratedUnits($cityId, $branchId){
        $city = City::where('id', '=', $cityId)->first();
        $branch = Branch::where('id', '=', $branchId)->first();
        
        $availableUnits = Unit::where('branch_id', '=', $branchId)
        ->where('is_available', '=', true)
        ->where('type', '=', 'refrigerated')
        ->get();
        $sizes = Size::get();

        return view('pages.refrigeratedRentingForm')
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
        $rentalDuration = intval($request->rentalMonths);


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
        $totalPrice *= $rentalDuration;


        //Change the availablility of the units for each size
        $allSmallAvailableUnits = Unit::where('size_id', '=', 1)
        ->where('branch_id', '=', $branchId)
        ->where('type', '=', 'normal')
        ->where('is_available', '=', true)->get();

        $allMediumAvailableUnits = Unit::where('size_id', '=', 2)
        ->where('branch_id', '=', $branchId)
        ->where('type', '=', 'normal')
        ->where('is_available', '=', true)->get();

        $allLargeAvailableUnits = Unit::where('size_id', '=', 3)
        ->where('branch_id', '=', $branchId)
        ->where('type', '=', 'normal')
        ->where('is_available', '=', true)->get();

        $unitsIds = [];
        for($i = 1; $i <= $units[1]; $i++){
            $allSmallAvailableUnits[$i - 1]->is_available = false;
            $allSmallAvailableUnits[$i - 1]->update();
            array_push($unitsIds, $allSmallAvailableUnits[$i - 1]->id);
        }
        for($i = 1; $i <= $units[2]; $i++){
            $allMediumAvailableUnits[$i - 1]->is_available = false;
            $allMediumAvailableUnits[$i - 1]->update();
            array_push($unitsIds, $allMediumAvailableUnits[$i - 1]->id);

        }
        for($i = 1; $i <= $units[3]; $i++){
            $allLargeAvailableUnits[$i - 1]->is_available = false;
            $allLargeAvailableUnits[$i - 1]->update();
            array_push($unitsIds, $allLargeAvailableUnits[$i - 1]->id);
        }

        $placedOrder = unit_order::create([
            'user_id' => $userId,
            'branch_id' => $branchId,
            'units' => json_encode($unitsIds),
            'rental_duration' => $rentalDuration,
            'start_date' => now(),
            'end_date' => now()->copy()->addMonths($rentalDuration),
            'total_price' => $totalPrice,
            'status' => 'confirmed',
        ]);
        return view('pages.confirmation')
        ->with('placedOrder', $placedOrder);
    }
    public function proccessRefrigeratedOrder(Request $request){
        $cityId = $request->city_id;
        $branchId = $request->branch_id;
        $units = $request->sizes;
        $userId = $request->user_id;
        $rentalDuration = intval($request->rentalMonths);


        //Calculate the total price
        $unitPrice = 300;
        $totalPrice = $unitPrice * $units[1];
        $totalPrice *= $rentalDuration;


        //Change the availablility of the units
        $allAvailableUnits = Unit::where('branch_id', '=', $branchId)
        ->where('type', '=', 'refrigerated')
        ->where('is_available', '=', true)->get();

        $unitsIds = [];
        for($i = 1; $i <= $units[1]; $i++){
            $allAvailableUnits[$i - 1]->is_available = false;
            $allAvailableUnits[$i - 1]->update();
            array_push($unitsIds, $allAvailableUnits[$i - 1]->id);
        }

        $placedOrder = unit_order::create([
            'user_id' => $userId,
            'branch_id' => $branchId,
            'units' => json_encode($unitsIds),
            'rental_duration' => $rentalDuration,
            'start_date' => now(),
            'end_date' => now()->copy()->addMonths($rentalDuration),
            'total_price' => $totalPrice,
            'status' => 'confirmed',
        ]);
        return view('pages.confirmation')
        ->with('placedOrder', $placedOrder);
    }


    public function viewUserProfile(){
        //return auth()->user();
        return view('pages.profile');
    }

    public function viewOrderDetails($orderId){
        //TODO: Check for auth before viewing the details
        $order = unit_order::findOrFail($orderId);
        return view('pages.orderDetails')->with('order', $order);
    }

    public function viewAdminDashboard(){
        //TODO: Check if admin
        $orders = unit_order::get();
        return view('pages.dashboard')->with('orders', $orders);
    }

    public function reviewOrder($orderId){
        $order = unit_order::findOrFail($orderId);
        return view('pages.review')->with('order', $order);
    }

    public function orderConfirm($orderId){
        $order = unit_order::findOrFail($orderId);
        $order->status = 'confirmed';
        $order->update();
        return redirect("/reviewOrder/$orderId");
    }
    public function orderCancel($orderId){
        $order = unit_order::findOrFail($orderId);
        $order->status = 'canceled';
        $order->update();
        return redirect("/reviewOrder/$orderId");
    }

    public function viewPlans(){
        $plans = Plan::all();
        return view('pages.plans')->with('plans', $plans);
    }
    public function PurchasePlan($planId){
        //TODO: Check if user has this plan
        $plan = Plan::findOrFail($planId);
        return view('pages.buyPlan')->with('plan', $plan);
    }


}
