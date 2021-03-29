<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function orderByPrice(Request $request) {
        $searched = $request->searched;
        $products = Product::where('name', 'like', "%$searched%")->orwhere('brand', 'like', "%$searched%")->get();
        switch ($request->order) {
            case 'desc':
                $products = $products->sortByDesc('price');
                $products = array_values($products->toArray());
                break;
            case 'asc':
                $products = $products->sortBy('price');
                $products = array_values($products->toArray());
                break;
            default:
                $products = [];
                break;
        }

        return response()->json([
            'results' => $products
        ]);
    }
}
