<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Construction;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $banner = Banner::first();
        $constructions = Construction::orderBy('created_at', 'desc')->get();
        $setting = Setting::first() ?? new Setting();

        return view('index', compact('banner', 'constructions', 'setting'));
    }
}
