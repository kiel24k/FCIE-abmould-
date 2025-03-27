<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLogs extends Model
{
    use HasFactory;

    protected $table = 'item_logs';
    protected $fillable = [
        'user_id',
        'action',
        'date_created',
        'time'
    ];
   public $timesptamps = true;
}
