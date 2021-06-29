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
        return DB::table('users')->select("*")->get();
    }

    public function headings(): array
    {
        return ["ID", "First Name", "Last Name", "Email", "Phone No", "Username", "Password",
                    "Street1", "Street2", "City", "State", "Country", "Pincode", "Active", "Joined Date",
                "User Role"];
    }
}
