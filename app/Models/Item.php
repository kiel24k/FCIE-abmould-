<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $fillable = [
        'user_id',
        'item_code',
        'supplier_name',
        'unit_cost',
        'quantity',
        'treshold',
        'total_cost',
        'out_of_stock_notif',
        'description',
        'category',
        'brand',
        'release_date'
        // 'barcode'
    ];
}
