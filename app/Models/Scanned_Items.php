<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scanned_Items extends Model
{
    use HasFactory;

    protected $table = 'scanned__items';
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
