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
                    ->join('orders', 'billing.id', '=', 'orders.item_id')
                    ->join('orders', 'billing.id', '=', 'orders.user_id')
                    ->select('billing.id','billing.bill_no', 'billing.bill_date','orders.user_name',
                    'orders.phone','orders.item_name', 'billing.grand_total','billing.active')
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
     
                           $btn = '<i class="fa fa-eye" aria-hidden="true"></i>
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
        $allbill = DB::select('select * from billing');
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
        $results = DB::insert('insert into billing(bill_no,bill_date,phone,user_role,active) 
        values (?,?,?,?,?)', [$uname,$uemail,$uphone,$userrole,$active]);

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
        $uname = $request->user_name;
        $uemail = $request->email;
        $uphone = $request->phone;
        $userrole = $request->user_role;
        $active = $request->active;
        
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $result = DB::update('update users set user_name = ?, email = ?, 
        phone = ?, user_role = ?, active = ? where id = ?', [$uname, $uemail, $uphone, $userrole, $active, $id]);

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
}
