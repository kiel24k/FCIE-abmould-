<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\AnnouncementCreated;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
  public function lowStockAlert()
  {
    $user = User::find(1); // Find a user by ID
    $message = "I found that our stock is currently low, with only 30 units remaining, which is concerning given that we typically maintain a higher inventory to meet customer needs and avoid potential stockouts.";

    // Send the notification
    $user->notify(new AnnouncementCreated($message));
  }
}
