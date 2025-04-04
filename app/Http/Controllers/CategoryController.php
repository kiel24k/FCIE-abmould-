<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function allItemCategory () {
        $data = Category::select('name')->orderBy('id', 'DESC')->get();
        return response()->json($data);
    }
}
