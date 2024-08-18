<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementCreated;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
  public function store (Request $request){
    $announcement = Announcement::create([
        'title' => "dsds",
        'description' => "dsdsds"
    ]);

    $user = User::first();
    // $user->notify(new AnnouncementCreated($announcement));
    return response()->json($user);
  }
}
