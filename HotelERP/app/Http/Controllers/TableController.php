<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableController extends Controller
{
    public function tablesList()
    {
        $result = DB::table('tables')->paginate(5);
        return view('tables.tableslist',['result' => $result]);
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
        
        $filename = "";
        
        if($request->hasFile('name'))
        {
            $filename = $request->item_image->getClientOriginalName();

            if($request->item_image)
            {
                $request->item_image->storeAs('img',$filename,'public');
            }
            
           // $path->save();
           // $request->item_image->update(['item_image'=>$filename]);
           // session()->put('message','Image Uploaded...');
        }

        $title = QrCode::size(500)
            ->format('svg')
            ->generate($request->name, public_path($filename));
        
        // # Instantiate LoadOption object using SVG load option
        // $options = new SvgLoadOptions();

        // # Create document object
        // $pdf = new Document($dataDir . 'Example.svg', $options);

        // # Save the output to XLS format
        // $pdf->save($dataDir . "SVG.pdf");
    
        
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
}
