<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;


class OrderController extends Controller
{
    public function orderList()
    {
        $result = DB::table('orders')->paginate(5);
        return view('orders.orderlist',['result' => $result]);
    }
}
