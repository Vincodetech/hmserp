<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithHeadings;


class FoodCategoryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('food_category')->select("*")->get();
    }

    public function headings(): array
    {
        return ["ID", "Category Name", "Category Type", "Category Image", "Category Quantity", "Active"];
    }
}
