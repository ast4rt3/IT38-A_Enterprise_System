<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeatureController extends Controller
{
   public function index()
{
    return view('features'); // Return the features page view
}

}
