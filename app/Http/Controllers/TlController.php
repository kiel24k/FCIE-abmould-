<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Schedule;
use Illuminate\Http\Request;

class TlController extends Controller
{
    public function getItem(Request $request)
    {
        if (!$request->category) {
            $allItem = Item::latest()
                ->paginate(10);
            return response()->json($allItem);
        } else if ($request->category) {
            $item = Item::where('category', '=', $request->category)
                ->latest()
                ->paginate(10);
            return response()->json($item);
        }
    }
    public function itemSearchlist(Request $request)
    {
        if (!$request->category) {
            $allItem = Item::where('item_code', 'LIKE', '%' . $request->search . '%')
                ->latest()
                ->paginate(10);
            return response()->json($allItem);
        } else if ($request->category) {
            $item = Item::where('category', '=', $request->category)
                ->where('item_code', 'LIKE', '%' . $request->search . '%')
                ->latest()
                ->paginate(10);
            return response()->json($item);
        }
    }


public function getDateSchedule () {
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
    public function updateScheduleStatus (Request $request) {
        $schedule = Schedule::find($request->id);
        $schedule->status = $request->status;
        $schedule->update();
        return response()->json($schedule);
    }
}
