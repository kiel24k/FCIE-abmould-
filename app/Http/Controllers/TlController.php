<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TlController extends Controller
{
    public function itemCategory(Request $request)
    {
        $item = DB::table('items')
            ->select('category')
            ->orderBy('id', 'DESC')
            ->get();
        return response()->json($item);
    }
    public function items(Request $request)
    {
        if (empty($request->category) && empty($request->search)) {
            $item = DB::table('items')
                ->orderBy('id', 'DESC')
                ->get();
            return response()->json($item);
        }else if(empty($request->category) && isset($request->search)){
            $item = DB::table('items')
            ->select('*')
            ->where('item_code', 'LIKE' , '%' . $request->search . '%')
            ->orWhere('supplier_name', 'LIKE' , '%' . $request->search . '%')
            ->orWhere('unit_cost', 'LIKE' , '%' . $request->search . '%')
            ->orWhere('category', 'LIKE' , '%' . $request->search . '%')
            ->orWhere('description', 'LIKE' , '%' . $request->search . '%')
            ->orWhere('brand', 'LIKE' , '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->get();
            return response()->json($item);

        }else if(isset($request->category) && empty($request->search)){
            $item = DB::table('items')
                    ->select('*')
                    ->where('category', '=' , $request->category)
                    ->orderBy('id', 'DESC')
                    ->get();
                    return response()->json($item);
        }
    }
//dsdadsad
    public function getDateSchedule()
    {
        $data = Schedule::select('date_schedule')->get();
        $data->prepend(['date_schedule' => 'all']); // Add 'all' at the beginning

        return response()->json($data);
    }

    public function scheduleList(Request $request)
    {
        $search = $request->search;
        $category = $request->category;
        if ((empty($category) || $category == 'all') && empty($search)) {
            $item = Schedule::get();
            return response()->json($item);
        } else if ((empty($category) || $category == 'all' && !empty($search))) {
            $item = Schedule::where(function ($query) use ($search) {
                $query->where('supplier_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('item_code', 'LIKE', '%' .  $search . '%')
                    ->orWhere('quantity', 'LIKE', '%' .  $search . '%')
                    ->orWhere('status', 'LIKE', '%' .  $search . '%')
                    ->orWhere('date_schedule', 'LIKE', '%' .  $search . '%');
            })->get();
            return response()->json($item);
        } else if ((!empty($category) && empty($search))) {
            $item = Schedule::where('date_schedule', $category)->get();
            return response()->json($item);
        } else if ((!empty($category) && !empty($search))) {
            $item = Schedule::where('date_schedule', '=', $category)
                ->where(function ($query) use ($search) {
                    $query->where('supplier_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('item_code', 'LIKE', '%' .  $search . '%')
                        ->orWhere('quantity', 'LIKE', '%' .  $search . '%')
                        ->orWhere('status', 'LIKE', '%' .  $search . '%')
                        ->orWhere('date_schedule', 'LIKE', '%' .  $search . '%');
                })->get();
            return response()->json($item);
        }
    }
    public function updateScheduleStatus(Request $request)
    {
        $schedule = Schedule::find($request->id);
        $schedule->status = $request->status;
        $schedule->update();
        return response()->json($schedule);
    }

    public function countStatus()
    {
        $data = DB::table('schedules')
            ->select('status')
            ->selectRaw('COUNT(*) as status_count')
            ->groupBy('status')
            ->get();
        return response()->json($data);
    }
}
