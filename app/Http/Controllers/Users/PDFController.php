<?php
namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use PDF;
use app\Models\User;
use App\Http\Controllers\Controller; // Make sure you're extending the base controller class
use Illuminate\Foundation\Auth\User as AuthUser;
use Mpdf\Mpdf;

class PDFController extends Controller
{


    public function generatePDF()
    {
        $users = AuthUser::all()->map(function ($user) {
            if ($user->created_at !== null) {
                $user->formatted_created_at = $user->created_at->format('Y-m-d');
            } else {
                $user->formatted_created_at = null; // Handle null created_at
            }
            return $user;
        });
    
        // Load the PDF view with Arabic text
        $pdf = PDF::loadView('pdf.pdf-template', compact('users'));
    
        // Return or download the PDF
        return $pdf->download('users.pdf');
    }
    
}


