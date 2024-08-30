<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class InventoryManagerController extends Controller
{
    public function getItemList(Request $request)
    {

        $sort_column_name = $request->query('sort_column_name', 'item_code');
        $sort_order = $request->query('sort_order', 'asc');
        if (!$request->category) {
            $allitem = Item::orderBy($sort_column_name, $sort_order)->paginate(5);
            return response()->json($allitem);
        } else if ($request->category) {
            $item = Item::where('category', '=', $request->category)
                ->orderBy($sort_column_name, $sort_order)->paginate(5);
            return response()->json($item);
        }
    }

    public function itemSearchList(Request $request)
    {
        if (!$request->category) {
            $item = Item::where('item_code', 'LIKE', '%' . $request->search . '%')
                ->latest()
                ->paginate(10);
            return response()->json($item);
        } else if ($request->category) {
            $categoryItem = Item::where('category', '=', $request->category)
                ->where('item_code', 'LIKE', '%' . $request->search . '%')
                ->latest()
                ->paginate(10);
            return response()->json($categoryItem);
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
}
