<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function createInHistory(Request $request)
    {
        $history = new History();
        $history->date = $request->date;
        $history->category = $request->category;
        $history->item_code = $request->item_code;
        $history->barcode = $request->barcode;
        $history->change_by_name = $request->change_by_name;
        $history->made = $request->made;
        $history->save();
        return response()->json($history);
    }
    public function createOutHistory(Request $request)
    {
        $history = new History();
        $history->date = $request->date;
        $history->category = $request->category;
        $history->item_code = $request->item_code;
        $history->barcode = $request->barcode;
        $history->change_by_name = $request->change_by_name;
        $history->made = $request->made;
        $history->save();
        return response()->json($history);
    }

    public function getInHistory()
    {
        $history = History::orderBy('id', 'asc')->paginate(10);
        return response()->json($history);
    }
}
