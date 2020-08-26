<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChangePhotoController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Where to redirect users after password is changed.
     *
     * @var string $redirectTo
     */
    protected $redirectTo = '/change_photo';

    /**
     * Change password form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showChangePhotoForm()
    {
        $user = Auth::getUser();

        return view('auth.change_photo', compact('user'));
    }

    /**
     * Change photo.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function changePhoto(Request $request)
    {
        $user = Auth::getUser();
        $id = $user->id;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = $id.'.'.strtolower($file->getClientOriginalExtension());
            $destinationPath = 'users';
            if (file_exists($destinationPath.'/'.$id.'.jpg'))
            {
                unlink($destinationPath.'/'.$id.'.jpg');
            }
            if (file_exists($destinationPath.'/'.$id.'.png'))
            {
                unlink($destinationPath.'/'.$id.'.png');
            }
            $file->move($destinationPath, $name);
        }
        return redirect()->route('change_photo');
    }

}
