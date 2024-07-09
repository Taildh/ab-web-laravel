<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    public function index()
    {
        $banner = Banner::first() ?? new Banner();
        return view('backend.banner.index', compact('banner'));
    }

    public function store(BannerRequest $request)
    {
        $banner = Banner::first() ?? new Banner();

        try {
            $banner->title = $request->title;
            $banner->short_desc = $request->short_desc;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = $request->file('image')->storeAs('banners', $filename, 'public');
                $banner->image = $path;
            }

            if ($request->hasFile('image_mobile')) {
                $file = $request->file('image_mobile');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = $request->file('image_mobile')->storeAs('banners', $filename, 'public');
                $banner->image_mobile = $path;
            }

            $banner->save();

            return redirect()->route('banner.index')->with('success', 'Lưu banner thành công');
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->route('banner.index')->with('error', 'Có lỗi khi lưu banner');
        }
    }
}
