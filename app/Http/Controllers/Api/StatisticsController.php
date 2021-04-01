<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function getNumOfItems(Request $request) {
        $product_id = $request->productId;
        $orders = Order::whereYear('created_at', date($request->year))->get();
        $orders = $orders->filter(function($order) {
            return $order->payments->last() ? $order->payments->last()->accepted : false;
        });
        $orders = $orders->groupBy(function($order) {
            return Carbon::parse($order->created_at)->format('m');
        });
        if ($product_id) {
            $num_of_items = $orders->map(function($orders_per_month) use ($product_id) {
                return $orders_per_month->reduce(function($quantity, $order) use ($product_id) {
                    $product = $order->products->find($product_id);
                    $product_quantity = $product ? $product->pivot->quantity : 0;
                    return $quantity + $product_quantity;
                });
            });
        } else {
            $num_of_items = $orders->map(function($orders_per_month) {
                return $orders_per_month->reduce(function($quantity, $order) {
                    return $quantity + $order->quantity;
                });
            });
        }

        return response()->json([
            'results' => $num_of_items
        ]);
    }

    public function getRevenues(Request $request) {
        $product_id = $request->productId;
        $orders = Order::whereYear('created_at', date($request->year))->get();
        $orders = $orders->filter(function($order) {
            return $order->payments->last() ? $order->payments->last()->accepted : false;
        });
        $orders = $orders->groupBy(function($order) {
            return Carbon::parse($order->created_at)->format('m');
        });
        if ($product_id) {
            $revenues = $orders->map(function($orders_per_month) use ($product_id) {
                return $orders_per_month->reduce(function($amount, $order) use ($product_id) {
                    $product = $order->products->find($product_id);
                    $product_amount = $product ? $product->pivot->quantity*$product->price : 0;
                    return $amount + $product_amount;
                });
            });
        } else {
            $revenues = $orders->map(function($orders_per_month) {
                return $orders_per_month->reduce(function($amount, $order){
                    return $amount + $order->amount;
                });
            });
        }

        return response()->json([
            'results' => $revenues
        ]);
    }
}
