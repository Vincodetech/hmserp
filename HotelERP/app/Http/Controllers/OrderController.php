<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;



class OrderController extends Controller
{
    public function orderList()
    {
        if(request()->ajax())
        {
                $data = DB::table('orders')
                        ->select('id','item_id', 'order_type', 'table_id', 'orderid', 'order_status',
                         'active')
                        ->get();
            
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('item_id', function ($data) { 
            
                    $sql = DB::table('food_item')->where('id',$data->item_id)->first();
                    return $sql->name;
            })
            ->addColumn('table_id', function ($data) { 
            
                $sql = DB::table('tables')->where('id',$data->table_id)->first();
                return $sql->name;
            })
            ->addColumn('active', function($data){
                if($data->active == '1')
                {
                    $btn1 = '<span class="badge badge-success">Active</span>';
                }
                else
                {
                    $btn1 = '<span class="badge badge-danger">InActive</span>';
                }
                 return $btn1;
            })
            ->addColumn('Action', function($data){
                
                    $btn = '<i class="fa fa-edit"></i>
                            <i class="fa fa-trash"></i>';
                           
                            return $btn;
                           
                    })
            ->rawColumns(['item_id','table_id','active','Action'])->make(true);
        }
        $order = DB::table('orders')
                        ->select('orderid')
                        ->groupBy('orderid')
                        ->orderBy('orderid', 'ASC')
                        ->get();
        $result = DB::table('orders')->select("*")->get();                            
        return view('orders.orderlist', compact('order'), ['result' => $result]);

    }
}
