<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Mail;
use App\Mail\DemoEmail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

//    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        $error = Input::get('error');
        $success = Input::get('success');
        if ($error != "")
            return view('auth.passwords.email', compact('error'));
        if ($success != "")
            return view('auth.passwords.email', compact('success'));
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $error = 'We can\'t find a user with that e-mail address.';
        $result = DB::table('users')->select('*')->where('email', '=', $request->post('email'))->get();
        if (sizeof($result) < 1)
        {
            return redirect()->route('auth.password.reset', ['error'=>$error]);
        }else{
            DB::table('password_resets')->insert([
                ['email' => $request->post('email'), 'token' => $request->post('_token'), 'created_at'=>date('Y-m-d h:i:s')]
            ]);
            $objDemo = new \stdClass();
            $objDemo->title = '';
            $objDemo->content ='Hello!
<BR><BR>You are receiving this email because we received a password reset request for your account.
<BR><BR>Copy and paste the URL below into your web browser: 
<BR>http://www.dmiportal.com/password/reset/'.$request->post('_token')
                .'<BR><BR>Kind regards,<BR>Matthijs Terpstra';
            $objDemo->sender = 'Matthijs Terpstra';
            $objDemo->sender_email = 'admin@dmiportal.com';
            $objDemo->subject = 'Reset Password';
            Mail::to($request->post('email'))->send(new DemoEmail($objDemo));
            return redirect()->route('auth.password.reset', ['success'=>'We have e-mailed your password reset link!']);
        }
        exit;
    }
}
