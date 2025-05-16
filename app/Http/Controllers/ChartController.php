<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Carbon\Carbon;
use FFI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;

class ChartController extends Controller
{
    public function bargraph(Request $request)
    {

        if (empty($request->date_one) && empty($request->date_two)) {
            $categories = DB::table('items')
                ->select('category', DB::raw('SUM(quantity) as total_value'))
                ->where('release_date', Carbon::now()->timezone('Asia/Manila')->format('Y-m-d'))
                ->groupBy('category')
                ->get();
            return response()->json($categories);
        } else if (isset($request->date_one) && empty($request->date_two)) {
            $categories = DB::table('items')
                ->select('category', DB::raw('SUM(quantity) as total_value'))
                ->where('release_date', Carbon::parse($request->date_one)->timezone('Asia/Manila')->format('Y-m-d'))
                ->groupBy('category')
                ->get();
            return response()->json($categories);
        } else if (empty($request->date_one) && isset($request->date_two)) {
            $categories = DB::table('items')
                ->select('category', DB::raw('SUM(quantity) as total_value'))
                ->where('release_date',  Carbon::parse($request->date_two)->timezone('Asia/Manila')->format('Y-m-d'))
                ->groupBy('category')
                ->get();
            return response()->json($categories);
        } else if (isset($request->date_one) && isset($request->date_two)) {
            $categories = DB::table('items')
                ->select('category', DB::raw('SUM(quantity) as total_value'))
                ->whereBetween('release_date', [Carbon::parse($request->date_one)->timezone('Asia/Manila')->format('Y-m-d'),   Carbon::parse($request->date_two)->timezone('Asia/Manila')->format('Y-m-d')])
                ->groupBy('category')
                ->get();
            return response()->json($categories);
        }
    }
    public function lineGraph(Request $request)
    {

        if (empty($request->date_one) && empty($request->date_two)) {
            $data = DB::table('items')
                ->select('item_code', 'quantity')
               ->where('release_date', Carbon::parse($request->date_one)->timezone('Asia/Manila')->format('Y-m-d'))
                ->orderBy('quantity', 'DESC')
                ->limit(10)
                ->get();
            return response()->json($data);
        } else if (isset($request->date_one) && empty($request->date_two)) {
            $data = DB::table('items')
                ->select('item_code', 'quantity')
                ->where('release_date', Carbon::parse($request->date_one)->timezone('Asia/Manila')->format('Y-m-d'))
                ->orderBy('quantity', 'DESC')
                ->limit(10)
                ->get();
            return response()->json($data);
        } else if (empty($request->date_one) && isset($request->date_two)) {
            $data = DB::table('items')
                ->select('item_code', 'quantity')
                ->where('release_date',  Carbon::parse($request->date_two)->timezone('Asia/Manila')->format('Y-m-d'))
                ->orderBy('quantity', 'DESC')
                ->limit(10)
                ->get();
            return response()->json($data);
        } else if (isset($request->date_one) && isset($request->date_two)) {
            $data = DB::table('items')
                ->select('item_code', 'quantity')
                ->whereBetween('release_date', [Carbon::parse($request->date_one)->timezone('Asia/Manila')->format('Y-m-d'),   Carbon::parse($request->date_two)->timezone('Asia/Manila')->format('Y-m-d')])
                ->orderBy('quantity', 'DESC')
                ->limit(10)
                ->get();
            return response()->json($data);
        }
    }

    public function pieGraph()
    {
        $data = DB::table('items')
            ->select('category')
            ->selectRaw('COUNT(*) as category_count')
            ->groupBy('category')
            ->get();
        return response()->json($data);
    }

    public function dashboardCount()
    {
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

    public function tableDataDashboard()
    {
        $data = Item::select('id', 'item_code', 'supplier_name', 'quantity', 'unit_cost')
            ->orderBy('id', 'DESC')
            ->limit(15)
            ->get();
        return response()->json($data);
    }
}
