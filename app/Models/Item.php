<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $fillable = [
        'item_code',
        'supplier_name',
        'unit_cost',
        'quantity',
        'description',
        'category',
        'brand'
    ];
}
