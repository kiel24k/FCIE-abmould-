<?php

namespace App\Http\Controllers;

use App\Models\StockLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function tresholdLogs(Request $request)
    {
        $logs = new StockLogs();
        $logs->user_id = $request->id;
        $logs->action = "treshold";
        $logs->date_released = Carbon::now()->format('y-m-d');
        $logs->time = Carbon::now()->format('h:i A');
        $logs->save();
        return response()->json($logs);
    }

    public function quantityLogs(Request $request)
    {
        $logs = new StockLogs();
        $logs->user_id = $request->id;
        $logs->action = "quantity";
        $logs->date_released = Carbon::now()->format('y-m-d');
        $logs->time = Carbon::now()->format('h:i A');
        $logs->save();
        return response()->json($logs);
    }
}
