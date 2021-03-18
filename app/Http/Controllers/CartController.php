<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index() {
        return view('guest.cart.index');
    }

    public function store(Request $request) {
        Cart::add($request->id, $request->name, 1, $request->price)->associate('App\Product');

        return redirect()->route('cart.index')->with('item-added-message', 'Item added to cart');
    }

    public function empty() {
        Cart::destroy();

        return back();
    }

    public function deleteProduct($id) {
        Cart::remove($id);

        return back();
    }
}
