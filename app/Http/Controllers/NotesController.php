<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Support\Facades\DB;
use Redirect;
use PDF;

class NotesController extends Controller
{

    public function pdf($id){
        $result = DB::table('notification')
            ->leftJoin('users as a', 'notification.field', '=', 'a..name')
            ->leftJoin('users as b', 'notification.sender', '=', 'a..name')
            ->select('notification.*', 'a..email as field_email', 'b.email as sender_email')
            ->where('notification.id', $id)
            ->get();
        $one = $result[0];
        $sender = $one->sender;
        $field = $one->field;
        $subject = $one->subject;
        $message = $one->message;
        $date = $one->update_dt;
        $chconfirm = $one->chconfirm;
        $chdate = $one->chdate;
        $comment = $one->comment;
        $sender_email = $one->sender_email;
        $field_email = $one->field_email;
        $checked = '';
        if($chconfirm == 1) $checked = 'checked';
//        $html = '<table><tr><td style="width: 90px; background-color: #9abc9a;">Subject</td><td width="30px"></td><td width="50px">:</td><td>'.$subject.'</td></tr>';
//        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">Message</td><td width="30px"></td><td width="50px">:</td><td><pre>'.$message.'</pre></td></tr>';
//        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">Field</td><td width="30px"></td><td width="50px">:</td><td>'.$field.'</td></tr>';
//        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">E-Mail</td><td width="30px"></td><td width="50px">:</td><td>'.$field_email.'</td></tr>';
//        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">Sender</td><td width="30px"></td><td width="50px">:</td><td>'.$sender.'</td></tr>';
//        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">Date</td><td width="30px"></td><td width="50px">:</td><td>'.$date.'</td></tr>';
//        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">Confirmed</td><td width="30px"></td><td width="50px">:</td><td><input type="checkbox" '.$checked.' /></td></tr>';
//        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">Comment</td><td width="30px"></td><td width="50px">:</td><td>'.$comment.'</td></tr></table>';
//        $pdf = PDF::loadHTML($html);

        $html = '<table><tr><td style="width: 90px; background-color: #9abc9a;">From (Sender)</td><td width="30px"></td><td width="50px">:</td><td>'.$sender.'</td></tr>';
        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">E-mail (Sender)</td><td width="30px"></td><td width="50px">:</td><td><pre>'.$sender_email.'</pre></td></tr>';
        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">Sent date</td><td width="30px"></td><td width="50px">:</td><td>'.$date.'</td></tr>';
        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">To (Field)</td><td width="30px"></td><td width="50px">:</td><td>'.$field.'</td></tr>';
        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">E-mail (Field)</td><td width="30px"></td><td width="50px">:</td><td>'.$field_email.'</td></tr>';
        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">Acknowledged date</td><td width="30px"></td><td width="50px">:</td><td>'.$chdate.'</td></tr>';
        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">Confirmed</td><td width="30px"></td><td width="50px">:</td><td><input type="checkbox" '.$checked.' /></td></tr>';
        $html .= '<tr><td style="width: 90px; background-color: #9abc9a;">Comment from field</td><td width="30px"></td><td width="50px">:</td><td>'.$comment.'</td></tr></table>';
        $pdf = PDF::loadHTML($html);
        return $pdf->download('tuts_notes.pdf');
    }


}