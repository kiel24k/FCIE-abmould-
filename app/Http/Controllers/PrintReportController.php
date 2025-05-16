<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrintReportController extends Controller
{
    public function printItemList(Request $request)
    {
        if (empty($request->date_one) && empty($request->date_two)) {
            $data = DB::table('items')
                ->select('*')
                ->where('release_date', Carbon::now()->timezone('Asia/Manila')->format('Y-m-d'))
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
            return response()->json($data);
        } else if (isset($request->date_one) && empty($request->date_two)) {
            $data = DB::table('items')
                ->select('*')
                ->where('release_date', Carbon::parse($request->date_one)->timezone('Asia/Manila')->format('Y-m-d'))
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
            return response()->json($data);
        } else if (empty($request->date_one) && isset($request->date_two)) {
            $data = DB::table('items')
                ->select('*')
                ->where('release_date',  Carbon::parse($request->date_two)->timezone('Asia/Manila')->format('Y-m-d'))
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
            return response()->json($data);
        } else if (isset($request->date_one) && isset($request->date_two)) {
            $data = DB::table('items')
                ->select('*')
                ->whereBetween('release_date', [Carbon::parse($request->date_one)->timezone('Asia/Manila')->format('Y-m-d'),   Carbon::parse($request->date_two)->timezone('Asia/Manila')->format('Y-m-d')])
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
            return response()->json($data);
        }
    }

    public function printUserList(Request $request)
    {

if (empty($request->date_one) && empty($request->date_two)) {
            $data = DB::table('users')
                ->select('*')
                ->where('release_date', Carbon::now()->timezone('Asia/Manila')->format('Y-m-d'))
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
            return response()->json($data);
        } else if (isset($request->date_one) && empty($request->date_two)) {
            $data = DB::table('users')
                ->select('*')
                ->where('created_at', Carbon::parse($request->date_one)->timezone('Asia/Manila')->format('Y-m-d'))
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
            return response()->json($data);
        } else if (empty($request->date_one) && isset($request->date_two)) {
            $data = DB::table('users')
                ->select('*')
                ->where('created_at',  Carbon::parse($request->date_two)->timezone('Asia/Manila')->format('Y-m-d'))
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
            return response()->json($data);
        } else if (isset($request->date_one) && isset($request->date_two)) {
            $data = DB::table('users')
                ->select('*')
                ->whereBetween('created_at', [Carbon::parse($request->date_one)->timezone('Asia/Manila')->format('Y-m-d'),   Carbon::parse($request->date_two)->timezone('Asia/Manila')->format('Y-m-d')])
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
            return response()->json($data);
        }


        
    }
}
