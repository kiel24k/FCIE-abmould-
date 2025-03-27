<?php

namespace App\Http\Controllers;

use App\Models\ItemLogs;
use App\Models\StockLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogsController extends Controller
{
    public static function tresholdLogs($id)
    {
        $logs = new StockLogs();
        $logs->user_id = $id;
        $logs->action = "treshold";
        $logs->date_released = Carbon::now()->format('y-m-d');
        $logs->time = Carbon::now()->format('h:i A');
        $logs->save();
        return response()->json($logs);
    }

    public static function quantityLogs($id)
    {
        $logs = new StockLogs();
        $logs->user_id = $id;
        $logs->action = "quantity";
        $logs->date_released = Carbon::now()->format('y-m-d');
        $logs->time = Carbon::now('Asia/Manila')->format('h:i A');
        $logs->save();
        return response()->json($logs);
    }
    
    public function getLogs () {
        $logs = DB::table('stock_logs')
        ->leftJoin('users', 'users.id', '=', 'stock_logs.user_id')
        ->select('users.first_name','stock_logs.*')
        ->orderBy('id', 'DESC')
        ->get();
        return response()->json($logs);

    }

    public function removeLogs (Request $request) {
        $logs = StockLogs::find($request->id)->delete();
        return response()->json($logs);

    }
    public function test () {
        return date_default_timezone_get(); 
    }

    //ITEM CHANGES

    public function createdLogs ($id) {
        $logs = new ItemLogs();
        $logs->user_id = $id;
        $logs->action = 'created';
        $logs->date_created = Carbon::now()->format('y-m-d');
        $logs->time =  Carbon::now('Asia/Manila')->format('h:i A');
        $logs->save();
        return response()->json($logs);
    }

    public function updateLogs(Request $request) {
        return;
    }

    public function deletedLogs(Request $request) {
        return;
    }
}
