<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function bargraph()
    {
        $label = DB::table('items')
            ->select('category', 'quantity')
            ->orderBy('id', 'DESC')
            ->get();
        return response()->json($label);
    }
    public function lineGraph () {
        $data = DB::table('items')
        ->select('item_code','unit_cost')
        ->where('id' ,'<=', 10)
        ->orderBy('id', 'DESC')
        ->get();
        return response()->json($data);
    }

    public function pieGraph () {
        $data = DB::table('items')
        ->select('category')
        ->selectRaw('COUNT(*) as category_count')
        ->groupBy('category')
        ->get();
        return response()->json($data);
    }

    public function dashboardCount () {
        $item = DB::table('items')->count();
        $user = DB::table('users')->count();
        return response()->json([
            'item' => $item,
            'user' => $user
        ]);
    }
}
