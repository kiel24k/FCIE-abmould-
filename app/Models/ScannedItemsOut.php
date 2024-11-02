<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScannedItemsOut extends Model
{
    use HasFactory;

    protected $table = 'scanned_items_outs';
    protected $fillable = [
        'user_id',
        'item_id',
        'category',
        'item_code',
        'brand',
        'supplier_name',
        'unit_cost',
        'quantity',
        'description',
    ];
}
