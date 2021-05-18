<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BillingController extends Controller
{
    public function billingList()
    {
        if(request()->ajax())
        {
            $data = DB::table('billing')
                    ->join('orders', 'orders.id', '=', 'billing.order_id')
                    ->join('users','users.id', '=', 'orders.user_id')
                    ->join('food_item','food_item.id', '=', 'orders.item_id')
                    ->select('billing.id','billing.bill_no', 'billing.bill_date','users.user_name',
                    'users.phone','food_item.name','food_item.price', 'billing.grand_total','billing.active')
                    ->get();
            return datatables()->of($data)
            ->addIndexColumn()
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
     
                           $btn = '<a href="'.url('viewbilling/'.$data->id).'">
                           <i class="fa fa-eye" aria-hidden="true"></i></a>
                           <a href="'.url('updatebilling/'.$data->id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i></a>
                           <a href="'.url('deletebilling/'.$data->id).'" class="delete">
                           <i class="fa fa-trash" aria-hidden="true"></i></a>';
                           
                            return $btn;
                           
                    })
            ->rawColumns(['active','Action'])->make(true);
        }
        $bill = DB::table('billing')
                        ->select('bill_no')
                        ->groupBy('bill_no')
                        ->orderBy('bill_no', 'ASC')
                        ->get();
                        
        $result = DB::table('billing')->select("*")->get(); 
                       
        return view('billing.billinglist', compact('bill'), ['result' => $result]);

    }

    public function addBilling()
    {
        $allbill = DB::table('billing')
                    ->join('orders', 'orders.id', '=', 'billing.order_id')
                    ->join('users','users.id', '=', 'orders.user_id')
                    ->join('food_item','food_item.id', '=', 'orders.item_id')
                    ->select('billing.*','orders.orderid','users.user_name','food_item.name','orders.order_type','food_item.price')
                    ->get();
        // $allbill = DB::select('select * from billing');
        return view('billing.addbilling',['allbill' => $allbill]);
    }

    public function addPostBilling(Request $request)
    {
        $bno = $request->bill_no;
        $bdate = $request->bill_date;
        $oid = $request->order_id;
        $gtotal = $request->grand_total;
        $active = $request->active;
        
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $results = DB::insert('insert into billing(bill_no,bill_date,order_id,grand_total,active) 
        values (?,?,?,?,?)', [$bno,$bdate,$oid,$gtotal,$active]);

        if ($results != false) {
            return redirect('/addbilling')->with('roleSccssMsg', 'Bill Added Successfully.');
        } else {
            return redirect('/addbilling')->with('roleErrMsg', 'Bill add to failed!!');
        }
       return view('billing.addbilling');
    }

    public function updateBilling($id)
    {
        $singlebill = DB::table('billing')->where('id', $id)->first();
        return view('billing.updatebilling',['singlebill' => $singlebill]);
    }   
    
    public function postUpdateBilling(Request $request, $id)
    {
        $bno = $request->bill_no;
        $bdate = $request->bill_date;
        $oid = $request->order_id;
        $gtotal = $request->grand_total;
        $active = $request->active;
        
        
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $result = DB::update('update users set bill_no = ?, bill_date = ?, 
        order_id = ?, grand_total = ?, active = ? where id = ?', [$bno, $bdate, $oid, $gtotal, $active, $id]);

        if ($result != false) {
            return redirect('updatebilling/'. $id)->with('updateCategoryInMsg', 'Bill Updated Successfully');
        } else {
            return redirect('updatebilling/'. $id)->with('errUpdateCategoryInMsg', 'Bill not Updated');
        }
        return view('billing.updatebilling');
    }

    public function deleteBilling($id)
    {
        $data = DB::delete('delete from billing where id = ?', [$id]);

        if ($data != false) {
            return redirect('/billinglist')->with('deleteCategoryInMsg', 'Bill Deleted Successfully');
        } else {
            return redirect('/billinglist')->with('errDeleteCategoryInMsg', 'Bill not Deleted');
        }
        return view('billing.billinglist');
    }

    public function getOrderByOrderId(Request $request)
    {
        $orderid = $request->orderid;
        $orders = DB::table('orders')->where('orderid', $orderid)->get();    
        return $orders;            
    }

    public function getItemNameById(Request $request)
    {
        $item_id = $request->item_id;
        $items = DB::table('orders')
                ->join('food_item', 'food_item.id', '=', 'orders.item_id')
                ->select('food_item.name','food_item.price', 'orders.order_type')
                
                ->get();
    
        return $items;            
    }
}
