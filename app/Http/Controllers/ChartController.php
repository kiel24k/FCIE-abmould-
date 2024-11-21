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
            ->get();
        return response()->json($label);
    }
}
