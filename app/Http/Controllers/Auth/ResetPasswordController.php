<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function showResetForm(Request $request, $token = null)
    {
        if (isset($request->error) && $request->error != ""){
            return view('auth.passwords.reset')->with(
                ['token' => $token, 'email' => $request->email, 'error'=>$request->error, 'success'=>'']
            );
        }
        if (isset($request->success) && $request->success != ""){
            return view('auth.passwords.reset')->with(
                ['token' => $token, 'email' => $request->email, 'success'=>$request->success, 'error'=>'']
            );
        }
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    public function reset(Request $request)
    {
        $result = DB::table('password_resets')->select('token')
            ->where('token', '=', $request->token)
            ->where('email', '=', $request->email)
            ->get();
        if (sizeof($result) < 1){
            return redirect()->route('password.reset', [$request->token,'error'=>'This password reset token is invalid.']);
        }else{
            $email = $request->email;
            $password = $request->password;
            $password_confirmation = $request->password_confirmation;
            if ($password != $password_confirmation)
            {
                return redirect()->route('password.reset', [$request->token,'error'=>'Confirm password is incorrect.']);
            }
            DB::table('users')->where('email', $email)
                ->update(['password' => Hash::make($password)]);
            $result = DB::table('password_resets')
                ->where('token', '=', $request->token)
                ->where('email', '=', $request->email)
                ->delete();

            return redirect()->route('password.reset', [$request->token, 'success'=>'Password has been reseted successfully.']);
        }
        exit;
    }
}
