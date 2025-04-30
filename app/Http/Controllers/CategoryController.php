<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function allItemCategory()
    {
        $data = Category::select('name')->orderBy('id', 'DESC')->get();
        return response()->json($data);
    }



    public function scheduleItemCategory()
    {
        $category = Item::select('category')->distinct()->get();
        $item_code = Item::select('item_code')->distinct()->get();
        $supplier_name = Item::select('supplier_name')->distinct()->get();
        return response()->json([
            'category' => $category,
            'item_code' => $item_code,
            'supplier_name' => $supplier_name
        ]);
    }
}
