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
        ->select('item_code','quantity')
        ->orderBy('quantity', 'DESC')
        ->limit(10)
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
        $unit_cost = DB::table('items')
        ->sum('unit_cost');
        return response()->json([
            'item' => $item,
            'user' => $user,
            'unit_cost' => $unit_cost
        ]);
    }

    public function tableDataDashboard () {
        $data = Item::select('id','item_code','supplier_name', 'quantity','treshold')
        ->orderBy('id', 'DESC')
        ->limit(15)
        ->get();
        return response()->json($data);

    }
}
