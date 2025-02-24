<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    private $message = "Added Item";

    public static function addItemNotification()
    {
        $data = new Notification();
        $data->user_id = 4;
        $data->message = "Added Item";
        $data->save();
    }

    public function getJoinTable()
    {
     $users = DB::table('notifications')
            ->join('users', 'users.id', '=', 'notifications.user_id')  // Correct the join condition
            ->get();
            return response()->json($users);
    }
}
