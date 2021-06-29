<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableController extends Controller
{
    public function tablesList()
    {
        if(request()->ajax())
        {
            $data = DB::table('tables')
                    ->select('id', 'name', 'table_type', 'active')
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
     
                           $btn = '<a href="'.url('updatetables/'.$data->id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i></a>
                           <a href="'.url('deletetable/'.$data->id).'" class="delete">
                           <i class="fa fa-trash" aria-hidden="true"></i></a>';
                           
                            return $btn;
                           
                    })
            ->rawColumns(['active','Action'])->make(true);
        }
        $name = DB::table('tables')
                        ->select('name')
                        ->groupBy('name')
                        ->orderBy('name', 'ASC')
                        ->get();
                        
        $result = DB::table('tables')->select("*")->get(); 
        return view('tables.tableslist', compact('name'), ['result' => $result]);
    }

    public function addTables()
    {

        return view('tables.addtables');
    }

    public function addPostTables(Request $request)
    {
        $title = $request->name;
        $table_type = $request->table_type;
        $unique_key = $request->unique_key;
        $active = $request->active;
        
        
         if($active != 1)
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $results = DB::insert('insert into tables(name,table_type,unique_key,active) 
        values (?,?,?,?)', [$title,$table_type,$unique_key,$active]);

        if ($results == 1) {
            return redirect('/addtables')->with('roleSccssMsg', 'Table Added Successfully.');
        } else {
            return redirect('/addtables')->with('roleErrMsg', 'Table add to failed!!');
        }
       return view('tables.addtables');
    }

    public function updateTables($id)
    {
        $singletable = DB::table('tables')->where('Id', $id)->first();
        return view('tables.updatetables',['singletable' => $singletable]);
    }   
    
    public function postUpdateTables(Request $request, $id)
    {
        $title = $request->name;
        $table_type = $request->table_type;
        $unique_key = $request->unique_key;
        $active = $request->active;
        
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $result = DB::update('update tables set name = ?, table_type = ?, 
        unique_key = ?, active = ? where id = ?', [$title, $table_type, $unique_key, $active, $id]);

        if ($result == 1) {
            return redirect('updatetables/'. $id)->with('updateCategoryInMsg', 'Table Updated Successfully');
        } else {
            return redirect('updatetables/'. $id)->with('errUpdateCategoryInMsg', 'Table not Updated');
        }
        return view('tables.updatetables');
    }

    public function deleteTable($id)
    {
        $data = DB::delete('delete from tables where id = ?', [$id]);

        if ($data == 1) {
            return redirect('/tables')->with('deleteCategoryInMsg', 'Table Deleted Successfully');
        } else {
            return redirect('/tables')->with('errDeleteCategoryInMsg', 'Table not Deleted');
        }
        return view('tables.tableslist');
    }
}
