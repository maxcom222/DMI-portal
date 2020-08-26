<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use PDF;
class CustomerController extends Controller
{
    public function export_pdf()
    {
        $users = User::all();
        // Send data to the view using loadView function of PDF facade
        $pdf = PDF::loadView('notification.send_message', compact('users'));
//        exit("123");
        // If you want to store the generated pdf to the server then you can use the store function
        $pdf->save(storage_path().'_filename.pdf');
        // Finally, you can download the file using download function
        return $pdf->download('customers.pdf');
    }
}