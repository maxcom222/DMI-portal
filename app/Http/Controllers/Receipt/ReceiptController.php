<?php

namespace App\Http\Controllers\Receipt;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Mail;
use App\Mail\DemoEmail;

class ReceiptController extends Controller
{

    public function index()
    {
        if (Auth::user()->roles()->pluck('name')[0] == "field") {
            return abort(401);
        }
        $receiver = Input::get('receiver');
        $users = User::all();
        if ($receiver != "")
        {
            return view('receipt.upload_receipt', compact('users', 'receiver'));
        }

        return view('receipt.upload_receipt', compact('users'));
    }

    public function save(Request $request)
    {
        if (Auth::user()->roles()->pluck('name')[0] == "field") {
            return abort(401);
        }
        $field_array = $request->input('field') ? $request->input('field') : [];
        $sender = Auth::user()->name;
        $sender_email = Auth::user()->email;
        $date = date('Y-m-d');
        $receiver = '';
        if ($request->hasFile('selectfile')) {
            $file = $request->file('selectfile');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'upload';
            $file->move($destinationPath, $name);

            foreach ($field_array as $field)
            {
                DB::table('receipt')->insert([
                    ['sender' => $sender, 'field' => $field, 'filename' => $name, 'basefilename' => $file->getClientOriginalName()
                        , 'create_dt' => $date, 'update_dt' => $date]
                ]);
                $data = array('name'=>$field, 'title'=>'Hi, '.$field.'.', 'content'=>'You have received from '.$sender.'.');
                $result = DB::table('users')->where('name', $field)
                    ->select('*')->get();
                $to_email = $result[0]->email;
                $receiver .= $receiver==''?$field.'<'.$to_email.'>':','.$field.'<'.$to_email.'>';
                $objDemo = new \stdClass();

                $objDemo->title = 'Hello '.$field.',';
                $objDemo->content =
                    '<BR><BR>A new receipt has been uploaded at www.dmiportal.com by '.$sender.'.'
                    .'<BR>Please go to www.dmiportal.com and to see the uploaded receipt.'
                    .'<BR><BR>Kind regards,<BR>'
                    .$sender
                    .'<BR><BR>NOTE: this is a standard e-mail. You cannot reply on this e-mail.';
                $objDemo->sender = $sender;
                $objDemo->receiver = $field;
                $objDemo->sender_email = $sender_email;
                $objDemo->subject = 'New receipt';
                Mail::to($to_email)->send(new DemoEmail($objDemo));
            }
        }
        return redirect()->route('receipt.upload.index', ['receiver'=>$receiver]);
    }

    public function fieldreceipt()
    {
        if (Auth::user()->roles()->pluck('name')[0] == "field") {
            return abort(401);
        }
        $result = DB::table('receipt')
            ->leftJoin('users', 'receipt.field', '=', 'users.name')
//            ->where('receipt.sender', Auth::user()->name)
            ->select('receipt.*', 'users.email as field_email')
            ->orderBy('receipt.update_dt', 'desc')
            ->get();
        return view('receipt.fieldreceipts', compact('result'));
    }

    public function myreceipt()
    {
        if (Auth::user()->roles()->pluck('name')[0] != "field") {
            return abort(401);
        }
        $result = DB::table('receipt')
            ->leftJoin('users', 'receipt.sender', '=', 'users.name')
            ->where('receipt.field', Auth::user()->name)
            ->select('receipt.*', 'users.email as admin_email')
            ->orderBy('receipt.update_dt', 'desc')
            ->get();
        return view('receipt.myreceipts', compact('result'));
    }

    public function downfile($id)
    {

        DB::table('receipt')
            ->where('id', $id)
            ->update(['ch' => 1, 'chdate'=>date('Y-m-d')]);
        $result = DB::table('receipt')
            ->where('id', $id)
            ->select('filename', 'basefilename')
            ->get();
        $filename = $result[0]->filename;
        $basefilename = $result[0]->basefilename;
        return response()->download('upload/'.$filename, $basefilename);
    }

    public function getcontent(Request $request)
    {
        if (Auth::user()->roles()->pluck('name')[0] != "field") {
            return abort(401);
        }
        $sender = $request->get('sender');
        $time = $request->get('time');
        $result = DB::table('notification')->where('sender', $sender)->where('update_dt', $time)
            ->select('subject', 'message')->get();
        $result_content = '';
        foreach ($result as $one)
        {
            $result_content = $one->subject.'##'.$one->message;
        }
        return $result_content;
    }
    public function confirm(Request $request)
    {
        if (Auth::user()->roles()->pluck('name')[0] != "field") {
            return abort(401);
        }
        $sender = $request->post('sender');
        $time = $request->post('time');
        DB::table('notification')->where('sender', $sender)
            ->where('update_dt', $time)
            ->where('field', Auth::user()->name)
            ->update(['chconfirm' => 1]);
        return redirect()->route('notification.acknowledgment');
    }

    public function getcount()
    {
        if (Auth::user()->roles()->pluck('name')[0] != "field") {
            return abort(401);
        }
        $result = DB::table('receipt')->where('field', Auth::user()->name)->where('ch', 0)
            ->select('*')->get();
        return sizeof($result);
    }
    public function overview()
    {
        if (Auth::user()->roles()->pluck('name')[0] == "field") {
            return abort(401);
        }
        $result = DB::table('notification')
            ->leftJoin('users', 'notification.field', '=', 'users.name')
            ->select('notification.*', 'users.email as field_email')
            ->orderBy('notification.update_dt', 'desc')
            ->get();
        return view('notification.overview', compact('result'));
    }
    public function delete(Request $request)
    {
        if (Auth::user()->roles()->pluck('name')[0] == "field") {
            return abort(401);
        }
        if ($request->input('ids')) {
            DB::table('receipt')->whereIn('id', $request->input('ids'))->delete();
        }
    }
    public function acknowledgment(Request $request)
    {
        if (Auth::user()->roles()->pluck('name')[0] != "field") {
            return abort(401);
        }
        $result = DB::table('notification')
            ->where('field', '=', Auth::user()->name)
            ->where('chconfirm', '=', 0)
            ->select('sender', 'update_dt')->orderBy('update_dt', 'desc')->get();
        return view('notification.acknowledgment', compact('result'));
    }
}
