<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
   public function lowStockAlert () {
    $data = Item::where('quantity','<=', 25)
    // ->orWhere('quantity', '<=', 15)
    // ->orWhere('quantity', '<=', 5)
    ->orderBy('id', 'DESC')
    ->get();
    return response()->json($data);
   }
}
