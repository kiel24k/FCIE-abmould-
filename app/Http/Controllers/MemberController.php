<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class MemberController extends Controller
{

    public function itemCategory()
    {
        $data = Item::select('release_date')
            ->orderBy('id', 'DESC')
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
}
