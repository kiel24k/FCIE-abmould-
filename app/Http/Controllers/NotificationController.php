<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public static function addItemNotification($id)
    {
        $data = new Notification();
        $data->user_id = $id;
        $data->message = "Added new Item";
        $data->save();
    }

    public function getNotificationTable()
    {
     $users = DB::table('notifications')
            ->join('users', 'users.id', '=', 'notifications.user_id') 
            ->orderBy('notifications.id', 'DESC') // Correct the join condition
            ->get();
            return response()->json($users);
    }
}
