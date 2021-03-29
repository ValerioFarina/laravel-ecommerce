<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return view('guest.products.index', [
            'categories' => Category::all(),
            'products' => Product::all()
        ]);
    }

    public function show($slug) {
        return view('guest.products.show')->with('product', Product::where('slug', $slug)->firstOrFail());
    }

    public function searchProduct(Request $request) {
        $searched = $request->searched;
        $products = Product::where('name', 'like', "%$searched%")->orwhere('brand', 'like', "%$searched%")->get();
        return view('guest.products.searchProduct', [
            'searched' => $searched,
            'products' => $products,
            'categories' => Category::all()
        ]);
    }
}
