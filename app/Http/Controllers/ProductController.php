<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return view('guest.products.index')->with('products', Product::all());
    }

    public function show($slug) {
        return view('guest.products.show')->with('product', Product::where('slug', $slug)->firstOrFail());
    }
}
