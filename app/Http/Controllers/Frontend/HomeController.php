<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Construction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $banner = Banner::first();
        $constructions = Construction::all();

        return view('index', compact('banner', 'constructions'));
    }
}
