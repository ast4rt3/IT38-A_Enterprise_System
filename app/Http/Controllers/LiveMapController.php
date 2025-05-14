<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LiveMapController extends Controller
{
   public function index()
{
    return view('live-map'); // Return the live map page view
}

}
