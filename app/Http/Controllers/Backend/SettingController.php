<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Banner;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::first() ?? new Setting();
        return view('backend.settings.save', compact('setting'));
    }

    public function save(SettingRequest $request)
    {
        $setting = Setting::first() ?? new Setting();

        try {
            $setting->introduce_text = $request->introduce_text;
            $setting->facebook_url = $request->facebook_url;
            $setting->instagram_url = $request->instagram_url;
            $setting->email = $request->email;
            $setting->phone_number = $request->phone_number;
            $setting->address = $request->address;

            if ($request->hasFile('introduce_image')) {
                $file = $request->file('introduce_image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = $request->file('introduce_image')->storeAs('settings', $filename, 'public');
                $setting->introduce_image = $path;
            }

            $setting->save();

            return redirect()->route('settings.index')->with('success', 'Thiết lập thành công');
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->route('settings.index')->with('error', 'Có lỗi khi thiết lập');
        }
    }
}
