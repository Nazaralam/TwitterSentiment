<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sentiment;
use Illuminate\Support\Facades\Request as Request1;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Session;
use Storage;

class ProfileController extends Controller
{
    public function index()
    {
        if(!Session::has('pengguna'))
            return redirect()->route('index');
        return view('editprofile');
    }
    
    public function home()
    {
        if(!Session::has('pengguna'))
            return redirect()->route('index');
        $data = Sentiment::with('figure')->
            where('user_id', Session::get('pengguna')->id)->
            orderBy('created_at', 'desc')->get();
        return view('profile', ['data' => $data]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        $user1 = User::where('username', $request->username)->first();
        if($user1 != null) {
            if($user1->id != $user->id) {
                return view('editprofile', ['alert_msg' => 'Username is taken']);
            }
        }
        if($user == null) {
            return view('editprofile', ['alert_msg' => 'User not found']);
        }
        if(strlen($request->pass) > 0) {
            if(strlen($request->pass) < 8) {
                Request1::flashExcept(['pass', 'cpass', 'profile']);
                return view('editprofile', ['alert_msg' => 'Password minimum length is 8 characters']);
            } else if($request->pass != $request->cpass) {
                Request1::flashExcept(['pass', 'cpass', 'profile']);
                return view('editprofile', ['alert_msg' => 'Password not match with confirmation password']);
            }
            $user->password = Hash::make($request->pass);
        }
        $user->name = $request->name;
        $user->username = $request->username;
        if($request->hasFile('profile')) {
            Storage::delete('public/profile/'.$user->picture);
            $profile = $request->file('profile');
            $current_timestamp = Carbon::now()->timestamp; 
            $profileName = $current_timestamp."_".$user->id.".".$profile->extension();
            Storage::putFileAs('public/profile', $profile, $profileName);
            $user->picture = $profileName;
        }
        if(!$user->save()) {
            return view('editprofile', ['alert_msg' => 'Failed save data into database']);
        } else {
            Session::put('pengguna', $user);
        }
        return redirect()->route('profile');
    }
}
