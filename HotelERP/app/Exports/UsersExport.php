<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('food_item')->select("*")->get();
    }

    public function headings(): array
    {
        return ["ID", "Item Name", "Slug", "Category ID", "Item Image", "Unit", "Price",
                    "Description", "Quantity", "Item Type", "Active"];
    }
}
