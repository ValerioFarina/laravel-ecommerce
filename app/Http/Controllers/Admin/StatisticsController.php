<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index() {
        $oldest_date_time = Order::min('created_at');
        $oldest_year = intval(substr($oldest_date_time, 0, 4));
        $current_year = Carbon::now()->year;
        $years = [];
        for ($i=$current_year; $i>=$oldest_year; $i--) {
            $years[] = $i;
        }
        return view('admin.statistics.index', [
            'years' => $years,
            'products' => Product::all(),
            'categories' => Category::all()
        ]);
    }

    public function show($id) {
        $oldest_date_time = Order::min('created_at');
        $oldest_year = intval(substr($oldest_date_time, 0, 4));
        $current_year = Carbon::now()->year;
        $years = [];
        for ($i=$current_year; $i>=$oldest_year; $i--) {
            $years[] = $i;
        }
        return view('admin.statistics.show', [
            'years' => $years,
            'product_id' => $id
        ]);
    }
}
