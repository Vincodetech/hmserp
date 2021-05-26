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
                        ->select('id', 'table_id', 'order_no', 'order_type', 'order_status', 'payment_status',
                         'active')
                        ->get();
            
            return datatables()->of($data)
            ->addIndexColumn()
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
                if($data->order_status == 'Pending')
                {
                    $btn = '<a href="'.url('addbilling/'.$data->id).'" data-toggle="tooltip" title="Generate Bill">
                            <i class="fa fa-calculator"></i></a>
                            <a href="'.url('updateorder/'.$data->id).'">
                            <i class="fa fa-edit" aria-hidden="true"></i></a>
                            <a href="'.url('deleteorder/'.$data->id).'" class="delete">
                            <i class="fa fa-trash" aria-hidden="true"></i></a>';
                            return $btn;
                }
                else
                {
                 $btn = '<a href="'.url('updateorder/'.$data->id).'">
                        <i class="fa fa-edit" aria-hidden="true"></i></a>
                        <a href="'.url('deleteorder/'.$data->id).'" class="delete">
                        <i class="fa fa-trash" aria-hidden="true"></i></a>';
                        return $btn;
                }          
            })
            ->rawColumns(['table_id','active','Action'])->make(true);
        }
        $order = DB::table('orders')
                        ->select('id')
                        ->groupBy('id')
                        ->orderBy('id', 'DESC')
                        ->get();
        $result = DB::table('orders')->select("*")->get();                            
        return view('orders.orderlist', compact('order'), ['result' => $result]);

    }

    public function addOrder()
    {
        $alltables = DB::select('select * from tables');
        return view('orders.addorder',['alltables' => $alltables]);
    }

    public function addPostOrder(Request $request)
    {
        $tname = $request->table_id;
        $ono = $request->order_no;
        $otype = $request->order_type;
        $ostatus = $request->order_status;
        $pstatus = $request->payment_status;
        $active = $request->active;
        
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $results = DB::insert('insert into orders(table_id,order_no,order_type,order_status,payment_status,
        active) 
        values (?,?,?,?,?,?)', [$tname,$ono,$otype,$ostatus,$pstatus,$active]);

        if ($results != false) {
            return redirect('/addorder')->with('roleSccssMsg', 'Order Added Successfully.');
        } else {
            return redirect('/addorder')->with('roleErrMsg', 'Order add to failed!!');
        }
       return view('orders.addorder');
    }

    public function updateOrder($id)
    {
        $singleorder = DB::table('orders')->where('id', $id)->first();
        $alltables = DB::select('select * from tables');
        return view('orders.updateorder',['singleorder' => $singleorder,
         'alltables' => $alltables]);
    }   
    
    public function postUpdateOrder(Request $request, $id)
    {
        $tname = $request->table_id;
        $ono = $request->order_no;
        $otype = $request->order_type;
        $ostatus = $request->order_status;
        $pstatus = $request->payment_status;
        $active = $request->active;
        
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $result = DB::update('update users set table_id = ?, order_no = ?, 
        order_type = ?, order_status = ?,  payment_status = ?, active = ? where id = ?', [$tname, $ono,
         $otype, $ostatus, $pstatus, $active, $id]);

        if ($result != false) {
            return redirect('updateorder/'. $id)->with('updateCategoryInMsg', 'Order Updated Successfully');
        } else {
            return redirect('updateorder/'. $id)->with('errUpdateCategoryInMsg', 'Order not Updated');
        }
        return view('orders.updateorder');
    }

    public function deleteOrder($id)
    {
        $data = DB::delete('delete from orders where id = ?', [$id]);

        if ($data != false) {
            return redirect('/orderlist')->with('deleteCategoryInMsg', 'Order Deleted Successfully');
        } else {
            return redirect('/orderlist')->with('errDeleteCategoryInMsg', 'Order not Deleted');
        }
        return view('orders.orderlist');
    }
}
