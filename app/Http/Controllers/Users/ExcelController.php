<?php
namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport; // Create this export class
use App\Http\Controllers\Controller; // Make sure you're extending the base controller class

class ExcelController extends Controller
{
    public function generateExcel()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
