<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConstructionRequest;
use App\Models\Construction;
use App\Models\ConstructionImages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConstructionController extends Controller
{
    public function index()
    {
        $constructions = Construction::all();
        return view('backend.construction.index', compact('constructions'));
    }

    public function create()
    {
        $construction = new Construction();
        return view('backend.construction.save', compact('construction'));
    }

    public function save(ConstructionRequest $request, $id = null)
    {
        $construction = isset($id) ? Construction::find($id) : new Construction();

        DB::beginTransaction();
        try {
            $construction->title = $request->title;
            $construction->area = $request->area;
            $construction->description = $request->description;

            $construction->save();

            if (!empty($request->remove_images)) {
                ConstructionImages::whereIn('id', $request->remove_images)->delete();
            }

            $images = $request->file('images');

            if (!empty($images)) {
                foreach ($images as $image) {
                    $extension = $image->getClientOriginalExtension();
                    $filename = uniqid() . '.' . $extension;
                    $path = $image->storeAs('constructions', $filename, 'public');

                    ConstructionImages::create([
                        'construction_id' => $construction->id,
                        'path' => $path,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Lưu công trình thành công.']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            return response()->json(['error' => true, 'message' => 'Có lỗi khi lưu công trình.']);
        }
    }


    public function edit($id)
    {
        $construction = Construction::with(['images' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        return view('backend.construction.save', compact('construction'));
    }

    public function destroy($id) {
        try {
            Construction::find($id)->delete();

            return redirect()->route('construction.index')->with('success', 'Xóa công trình thành công');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->route('construction.index')->with('error', 'Có lỗi khi xóa công trình');
        }
    }
}
