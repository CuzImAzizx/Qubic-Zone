<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function Pest\Laravel\isAuthenticated;

class MainController extends Controller
{
    public function displayHomePage(){
        //I want to see if the user is auth
        //return "it works";
        return view('home');


    }
}
