<?php

namespace App\Http\Controllers\Notification;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Mail;
use App\Mail\DemoEmail;

class NotificationController extends Controller
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
            return view('notification.send_message', compact('users', 'receiver'));
        }

        return view('notification.send_message', compact('users'));
    }

    public function save(Request $request)
    {
        if (Auth::user()->roles()->pluck('name')[0] == "field") {
            return abort(401);
        }
        $field_array = $request->input('field') ? $request->input('field') : [];
        $subject = $request->post('subject');
        $message = $request->post('message');
        $sender = Auth::user()->name;
        $sender_email = Auth::user()->email;
        $date = date('Y-m-d');
        $receiver = '';
        foreach ($field_array as $field)
        {
            DB::table('notification')->insert([
                ['sender' => $sender, 'field' => $field, 'subject' => $subject
                    , 'message' => $message, 'create_dt' => $date, 'update_dt' => $date]
            ]);
            $data = array('name'=>$field, 'title'=>'Hi, '.$field.'.', 'content'=>'Received a notification from '.$sender.'.');
            $result = DB::table('users')->where('name', $field)
                ->select('*')->get();
            $to_email = $result[0]->email;
            $receiver .= $receiver==''?$field.'<'.$to_email.'>':','.$field.'<'.$to_email.'>';
            $objDemo = new \stdClass();

            $objDemo->title = 'Hello '.$field.',';
            $objDemo->content =
                '<BR><BR>You have received a transfer notification from '.$sender.'.'
                .'<BR>Please go to www.dmiportal.com and acknowledge the transfer.'
                .'<BR>The receipt will be uploaded as soon as possible within the system.'
                .'<BR><BR>Kind regards,<BR>'
                .$sender
                .'<BR><BR>NOTE: this is a standard e-mail. You cannot reply on this e-mail.';
            $objDemo->sender = $sender;
            $objDemo->receiver = $field;
            $objDemo->sender_email = $sender_email;
            $objDemo->subject = $subject;
            Mail::to($to_email)->send(new DemoEmail($objDemo));
        }
        return redirect()->route('notification.send.index', ['receiver'=>$receiver]);
    }

    public function reminder($id)
    {
        if (Auth::user()->roles()->pluck('name')[0] == "field") {
            return abort(401);
        }
        $date = date('Y-m-d');
        DB::table('notification')->where('id', $id)
            ->update(['update_dt' => $date]);
        return redirect()->route('notification.overview.index');
    }
    public function getcount()
    {
        if (Auth::user()->roles()->pluck('name')[0] != "field") {
            return abort(401);
        }
        $result = DB::table('notification')->where('field', Auth::user()->name)->where('chconfirm', 0)
            ->select('*')->get();
        return sizeof($result);
    }
    public function getcontent(Request $request)
    {
        if (Auth::user()->roles()->pluck('name')[0] != "field") {
            return abort(401);
        }
        $sender = $request->get('sender');
        $time = $request->get('time');
        $id = $request->get('id');
        $result = DB::table('notification')->where('id', $id)
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
        $comment = $request->post('comment');
        $rowid = $request->post('rowid');
        DB::table('notification')->where('id', $rowid)
            ->update(['chconfirm' => 1, 'chdate'=>date('Y-m-d'), 'comment'=>$comment]);
        return redirect()->route('notification.acknowledgment', ['success'=>'success']);
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
            DB::table('notification')->whereIn('id', $request->input('ids'))->delete();
        }
    }
    public function acknowledgment(Request $request)
    {
        if (Auth::user()->roles()->pluck('name')[0] != "field") {
            return abort(401);
        }
        $result = DB::table('notification')
            ->leftJoin('users', 'notification.sender', '=', 'users.name')
            ->where('field', '=', Auth::user()->name)
            ->where('chconfirm', '=', 0)
            ->select('notification.sender as sender', 'notification.subject as subject', 'notification.update_dt as update_dt', 'notification.id as id', 'users.email as email')->orderBy('update_dt', 'desc')->get();
        $success = Input::get('success');
        if ($success != "")
        {
            return view('notification.acknowledgment', compact('success', 'result'));
        }
        return view('notification.acknowledgment', compact('result'));
    }
    public function history()
    {
        if (Auth::user()->roles()->pluck('name')[0] != "field") {
            return abort(401);
        }
        $result = DB::table('notification')
            ->leftJoin('users', 'notification.sender', '=', 'users.name')
            ->where('field', '=', Auth::user()->name)
            ->select('notification.sender as sender', 'notification.subject as subject', 'notification.chconfirm as chconfirm', 'notification.update_dt as update_dt', 'users.email as admin_email')
            ->orderBy('update_dt', 'desc')->get();
        return view('notification.history', compact('result'));
    }
}
