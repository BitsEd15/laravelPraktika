<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return response()->json($products);
    }
    public function show( int $id)
    {
        $products = Product::find($id);
        if(!$products)
            return response()->json([
                'error'=>'Product not found'
            ]);
        return response()->json($products, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
