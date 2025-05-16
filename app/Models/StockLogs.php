<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLogs extends Model
{
    use HasFactory;

    protected $table = "stock_logs";
    protected $fillable = [
        'user_id',
        'item_id',
        'action',
        'date_released',
        'time'
    ];
   
}
