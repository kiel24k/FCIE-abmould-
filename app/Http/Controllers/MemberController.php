<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function getItem(Request $request)
    {
        if (!$request->category) {
            $allItem = Item::latest()
                ->paginate(10);
            return response()->json($allItem);
        }else if($request->category){
            $item = Item::where('category', '=', $request->category)
            ->latest()
            ->paginate(10);
            return response()->json($item);
        }
    }
}
