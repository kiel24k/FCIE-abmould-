<?php

namespace App\Http\Controllers;

use App\Models\ItemLogs;
use App\Models\StockLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogsController extends Controller
{
    public static function tresholdLogs($id,$itemId)
    {
        $logs = new StockLogs();
        $logs->user_id = $id;
        $logs->action = "treshold";
        $logs->item_id = $itemId;
        $logs->date_released = Carbon::now()->format('y-m-d');
        $logs->time = Carbon::now('Asia/Manila')->format('h:i A');
        $logs->save();
    }

    public static function quantityLogs($id, $itemId)
    {
        $logs = new StockLogs();
        $logs->user_id = $id;
        $logs->action = "quantity";
        $logs->item_id = $itemId;
        $logs->date_released = Carbon::now()->format('y-m-d');
        $logs->time = Carbon::now('Asia/Manila')->format('h:i A');
        $logs->save();
        return response()->json($logs);
    }

    public function getLogs()
    {
        $logs = DB::table('stock_logs')
            ->leftJoin('users', 'users.id', '=', 'stock_logs.user_id')
            ->select('users.first_name', 'stock_logs.*')
            ->orderBy('id', 'DESC')
            ->get();
        return response()->json($logs);
    }

    public function removeLogs(Request $request)
    {
        $logs = StockLogs::find($request->id)->delete();
        return response()->json($logs);
    }
    public function test()
    {
        return date_default_timezone_get();
    }

    //ITEM CHANGES

    public static function createdLogs($id,$itemId)
    {
        $logs = new ItemLogs();
        $logs->user_id = $id;
        $logs->action = 'created';
        $logs->item_id = $itemId;
        $logs->date_created = Carbon::now()->format('y-m-d');
        $logs->time = Carbon::now('Asia/Manila')->format('h:i A');
        $logs->save();
        return response()->json($logs);
    }

    public function getItemLogs()
    {
        $logs = DB::table('item_logs')
            ->leftJoin('users', 'item_logs.user_id', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.last_name',
                'users.email',
                'item_logs.id',
                'item_logs.user_id',
                'item_logs.action',
                'item_logs.date_created',
                'item_logs.time',
                'item_logs.item_id'
            )
            ->orderBy('item_logs.id', 'DESC')
            ->get();
        return response()->json($logs);
    }

    public function removeItemLogs(Request $request)
    {
        $logs = ItemLogs::find($request->id)->delete();
        return response()->json($logs);
    }

    public static function updateItemLogs($id,$itemId)
    {
        $logs = new ItemLogs();
        $logs->user_id = $id;
        $logs->action = 'update';
        $logs->item_id = $itemId;
        $logs->date_created = Carbon::now()->format('y-m-d');
        $logs->time = Carbon::now('Asia/Manila')->format('h:i A');
        $logs->save();
        return response()->json($logs);
    }

    public static function itemDeletedLogs($id)
    {
        $logs = new ItemLogs();
        $logs->user_id = $id;
        $logs->action = 'deleted';
        $logs->date_created = Carbon::now()->format('y-m-d');
        $logs->time = Carbon::now('Asia/Manila')->format('h:i A');
        $logs->save();
        return response()->json($logs);
    }
}
