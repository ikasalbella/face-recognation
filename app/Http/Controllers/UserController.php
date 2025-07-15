<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function importForm()
    {
        return view('users.import');
    }

    public function import(Request $request)
    {
        Excel::import(new UsersImport, $request->file('file'));

        return back()->with('success', 'Users imported successfully!');
    }
}
