<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {
        return response()->json([
            'result' => Cart::content()
        ]);
    }

    public function updateQuantity(Request $request) {
        Cart::update($request->rowId, $request->quantity);

        return response()->json([
            'result' => $request->quantity
        ]);
    }
}
