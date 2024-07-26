<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = 'materials';
    protected $fillable = [
        'item_code',
        'supplier_name',
        'unit_cost',
        'quantity',
        'description',
        'item_type',
    ];
}
