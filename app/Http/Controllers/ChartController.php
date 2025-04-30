<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function bargraph()
    {
        $categories = DB::table('items')
        ->select('category', DB::raw('SUM(quantity) as total_value'))
        ->groupBy('category')
        ->get();
    
        return response()->json($categories);
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
        $item = DB::table('items')->sum('quantity');
        $user = DB::table('users')->count();
        $unit_cost = DB::table('items')
        ->sum('total_cost');
        return response()->json([
            'item' => intVal($item),
            'user' => intVal($user),
            'unit_cost' => intVal($unit_cost)
        ]);
    }

    public function tableDataDashboard () {
        $data = Item::select('id','item_code','supplier_name', 'quantity','unit_cost')
        ->orderBy('id', 'DESC')
        ->limit(15)
        ->get();
        return response()->json($data);

    }
}
