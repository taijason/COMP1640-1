<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Session;

class UserController extends Controller
{
    public function register()
    {
        return view('customer.register');
    }

    public function login()
    {
        return view('customer.login');
    }

    public function registerProcess(Request $request)
    {
        $user = new User();
        $user->userID = $request->username;
        $user->userPass = Hash::make($request->password);
        $user->userName = $request->name;
        $user->userEmail = $request->email;
        $user->userPhone = $request->phone;
        $res = $user->save();
        if($res) {
            return back()->with('success', 'You have registered successfully!');
        } else {
            return back()->with('fail', 'Oh No! Something wrong!!!');
        }
    }

    public function loginProcess(Request $request)
    {
        $user = User::where('userID', '=', $request->username)->first();
        if($customer) {
            if(Hash::check($request->password, $user->userPass)) {
                $request->session()->put('loginID', $user->userID);
                return redirect('ideas');
            } else {
                return back()->with('fail', 'Password not matches!');
            }
        } else {
            return back()->with('fail', 'This email does not registered!');
        }
    }

    public function logout()
    {
        if(Session::has('loginID')) {
            Session::pull('loginID');
            return redirect('login');
        }
    }
}
