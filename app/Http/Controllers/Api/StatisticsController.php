<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function getNumOfItems(Request $request) {
        $orders = Order::whereYear('created_at', date($request->year))->get();
        $orders = $orders->filter(function($order) {
            return $order->payments->last() ? $order->payments->last()->accepted : false;
        });
        $orders = $orders->groupBy(function($order) {
            return Carbon::parse($order->created_at)->format('m');
        });
        $num_of_items = $orders->map(function($orders_per_month) {
            return $orders_per_month->reduce(function($quantity, $order){
                return $quantity + $order->quantity;
            });
        });

        return response()->json([
            'results' => $num_of_items
        ]);
    }

    public function getRevenues(Request $request) {
        $orders = Order::whereYear('created_at', date($request->year))->get();
        $orders = $orders->filter(function($order) {
            return $order->payments->last() ? $order->payments->last()->accepted : false;
        });
        $orders = $orders->groupBy(function($order) {
            return Carbon::parse($order->created_at)->format('m');
        });
        $revenues = $orders->map(function($orders_per_month) {
            return $orders_per_month->reduce(function($amount, $order){
                return $amount + $order->amount;
            });
        });

        return response()->json([
            'results' => $revenues
        ]);
    }
}
