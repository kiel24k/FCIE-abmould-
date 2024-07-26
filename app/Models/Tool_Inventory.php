<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool_Inventory extends Model
{
    use HasFactory;
    protected $table = 'tool_inventories';
protected $fillable = [
    'item_code',
    'brand',
    'supplier_name',
    'unit_cost',
    'quantity',
    'description'
];
}
