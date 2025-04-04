<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TlController extends Controller
{
    public function itemCategory()
    {
        $data = Item::select('release_date')
            ->orderBy('id', 'DESC')
            ->distinct()
            ->get();
        return response()->json($data);
    }

    public function itemList(Request $request)
    {
        $sortName = $request->query('sortName', 'id');
        $sortBy = $request->query('sortBy', 'DESC');
        if (empty($request->category) && empty($request->search)) {
            $data = Item::orderBy($sortName, $sortBy)->paginate(9);
            return response()->json($data);
        }
        if (isset($request->category) && empty($request->search)) {
            $data = Item::where('release_date', $request->category)
                ->orderBy($sortName, $sortBy)
                ->paginate(9);
            return response()->json($data);
        }
        if (empty($request->category) && isset($request->search)) {
            $data = Item::where('item_code', 'LIKE', '%' . $request->search . '%')
                ->orWhere('category', 'LIKE', '%' . $request->search . '%')
                ->orWhere('supplier_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                ->orderBy($sortName, $sortBy)
                ->paginate(9);
            return response()->json($data);
        } else if (isset($request->category) && isset($request->search)) {
            $data = Item::where('release_date', $request->category)
                ->where(function ($query) use ($request) {
                    $query->where('item_code', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('category', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('supplier_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->search . '%');
                })
                ->orderBy($sortName, $sortBy)
                ->paginate(9);
            return response()->json($data);
        }
    }

    public function scheduleListCategory()
    {
        $data = Schedule::select('date_schedule')
            ->orderBy('id', 'DESC')
            ->distinct()
            ->get();
        return response()->json($data);
    }

    public function scheduleList(Request $request)
    {
        if (empty($request->category) && empty($request->search)) {
            $data = Schedule::orderBy('id', 'DESC')->paginate(10);
            return response()->json($data);
        } else if (isset($request->category) && empty($request->search)) {
            $data = Schedule::where('date_schedule', $request->category)
                ->orderBy('id', 'DESC')
                ->paginate(9);
            return response()->json($data);
        }else if(empty($request->category) && isset($request->search)){
            $data = Schedule::where('supplier_name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('item_code', 'LIKE', '%' . $request->search . '%')
            ->orWhere('quantity', 'LIKE', '%' . $request->search . '%')
            ->orWhere('status', 'LIKE', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(9);
            return response()->json($data);
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
