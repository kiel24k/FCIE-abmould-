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

    public function itemSearchList(Request $request)
    {
        $searchTerm = $request->search;
        if (empty($request->category)) {
            $allItem = Item::where(function ($query) use ($searchTerm) {
                $query->where('item_code', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('supplier_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('unit_cost', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('quantity', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('category', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('brand', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            })
                ->paginate(10);
            return response()->json($allItem);
        } else if ($searchTerm) {
            $item = Item::where('category', '=', $request->category)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('item_code', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('supplier_name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('unit_cost', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('quantity', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('category', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('brand', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(10);
            return response()->json($item);
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


    public function category()
    {
        $items = Item::select('category')
            ->orderBy('id', 'DESC')
            ->get();
        return response()->json($items);
    }

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
    public function itemSearchlists(Request $request)
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
