<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
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
        return view('admin.statistics', ['years' => $years]);
    }
}
