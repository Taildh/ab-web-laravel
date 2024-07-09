<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Construction;
use Illuminate\Http\Request;

class ConstructionController extends Controller
{
    public function show(Request $request)
    {
        $id = $request->get('id');

        $construction = Construction::with('images')->find($id);

        if ($construction) {
            return response()->json($construction);
        }

        return response()->json(status: 404);
    }
}
