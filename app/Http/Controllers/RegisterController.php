<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Request as Request1;
use Illuminate\Support\Facades\Hash;
use Session;
use Storage;

class RegisterController extends Controller
{
    public function index()
    {
        if(Session::has('pengguna'))
            return redirect()->route('index');
        Request1::flashExcept('username');
        return view('register');
    }

    public function store(Request $request)
    {
        if($request->pass != $request->cpass) {
            Request1::flashExcept(['pass', 'cpass', 'profile']);
            return view('register', ['alert_msg' => 'Password not match with confirmation password']);
        } else if(User::where('username', $request->username)->first() != null) {
            Request1::flashExcept(['username', 'profile']);
            return view('register', ['alert_msg' => 'Username is exists']);
        }
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make($request->pass);
        if($user->save()) {
            if($request->hasFile('profile')) {
                $profile = $request->file('profile');
                $profileName = $user->id.".".$profile->extension();
                Storage::putFileAs('public/profile', $profile, $profileName);
                $user->picture = $profileName;
                $user->save();
            }
        } else {
            return view('register', ['alert_msg' => 'Registeration failed']);
        }
        Session::put('pengguna', $user);
        echo "<script>alert(\"Account has been created\");window.location.href='".route('index')."';</script>";
    }
}
