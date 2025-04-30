<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleRequest extends Model
{
    use HasFactory;
    protected $primaryKey = 'schedule_id';
    protected $table = 'schedule_requests';
    protected $fillable = [
        'user_id',
        'item_id',
        'quantity',
        'schedule_date',
        'status',
        'message'
    ];
}
