<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function bargraph() {
           $materials = DB::table('items')
           ->select('quantity')
           ->where('category', '=', 'materials')
           ->sum('quantity');

           $tools = DB::table('items')
           ->select('quantity')
           ->where('category' ,'=', 'tools')
           ->sum('quantity');
           return response()->json([
            'materials' => $materials,
            'tools' => $tools
           ]);

        //    $collection = collect([])
    }
}
