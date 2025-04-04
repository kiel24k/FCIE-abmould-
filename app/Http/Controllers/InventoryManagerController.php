<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryManagerController extends Controller
{
    public function itemCategory()
    {
        $category = Item::select('release_date')->orderBy('id', 'DESC')->get();
        return response()->json($category);
    }
    public function getItemList(Request $request)
    {
        $sortName = $request->query('sortName', 'id');
        $sortBy = $request->query('sortBy', 'ASC');

        if (empty($request->category) && empty($request->search)) {
            $data = Item::orderBy($sortName, $sortBy)->paginate(10);
            return response()->json($data);
        } else if (isset($request->category) && empty($request->search)) {
            $data = Item::where('release_date', $request->category)
                ->orderBy($sortName, $sortBy)
                ->paginate(10);
            return response()->json($data);
        } else if (empty($request->category) && isset($request->search)) {
            $data = Item::where('category', 'LIKE', '%' . $request->search . '%')
                ->orWhere('item_code', 'LIKE', '%' . $request->search . '%')
                ->orWhere('unit_cost', 'LIKE', '%' . $request->search . '%')
                ->orWhere('quantity', 'LIKE', '%' . $request->search . '%')
                ->orWhere('treshold', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                ->orderBy($sortName, $sortBy)
                ->paginate(10);
            return response()->json($data);
        } else if (isset($request->category) && isset($request->search)) {
            $data = Item::where('release_date', $request->category)
                ->where(function ($query) use ($request) {
                    $query->where('category', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('item_code', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('unit_cost', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('quantity', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('treshold', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->search . '%');
                })
                ->orderBy($sortName, $sortBy)
                ->paginate(10);
            return response()->json($data);
        }
    }


    public function getUpdatedItem($id)
    {
        $item = Item::find($id);
        return response()->json($item);
    }
    public function submitUpdatedItem(Request $request, $id)
    {
        $request->validate([
            'item_code' => 'required',
            'supplier_name' => 'nullable',
            'unit_cost' => 'numeric',
            'quantity' => 'numeric',
            'category' => 'required',
            'description' => 'required',
        ]);
        $item =  Item::find($id);
        $item->item_code = $request->item_code;
        $item->supplier_name = $request->supplier_name;
        $item->unit_cost = $request->unit_cost;
        $item->quantity = $request->quantity;
        $item->description = $request->description;
        $item->category = $request->category;
        $item->brand = $request->brand;
        $item->update();
        return response()->json($item);
    }

    public function deleteItem(Request $request)
    {
        Item::find($request->id)->delete();
    }


    public function category()
    {
        $items = Item::select('category')
            ->orderBy('id', 'DESC')
            ->get();
        return response()->json($items);
    }





    public function getDateScheduleCategory()
    {
        $data = Schedule::select('date_schedule')->get();
        return response()->json($data);
    }

    public function scheduleList(Request $request)
    {
        $sortName = $request->query('sortName', 'id');
        $sortBy = $request->query('sortBy', 'DESC');
        if (empty($request->category) && empty($request->search)) {
            $data = Schedule::orderBy($sortName, $sortBy)->paginate(10);
            return response()->json($data);
        }
        if (isset($request->category) && empty($request->search)) {
            $data = Schedule::where('date_schedule', $request->category)
                ->orderBy($sortName, $sortBy)
                ->paginate(10);
            return response()->json($data);
        } else if (empty($request->category) && isset($request->search)) {
            $data = Schedule::where('supplier_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('item_code', 'LIKE', '%' . $request->search . '%')
                ->orWhere('quantity', 'LIKE', '%' . $request->search . '%')
                ->orWhere('status', 'LIKE', '%' . $request->search . '%')
                ->orderBy($sortName, $sortBy)
                ->paginate(10);
            return response()->json($data);
        } else if (isset($request->category) && isset($request->search)) {
            $data = Schedule::where('date_schedule', $request->category)
                ->where(function ($query) use ($request) {
                    $query->where('supplier_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('item_code', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('quantity', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('status', 'LIKE', '%' . $request->search . '%');
                })
                ->orderBy($sortName, $sortBy)
                ->paginate(10);
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
    public function statusCount()
    {
        $status = DB::table('schedules')
            ->select('status')
            ->selectRaw('COUNT(*) as statusCount')
            ->groupBy('status')
            ->get();
        return response()->json($status);
    }
}
