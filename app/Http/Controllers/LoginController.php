<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;



class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            //return redirect('home');
            return redirect('dashboard');
        }else{
            return view('login');
        }
    }

    public function actionlogin(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'), 
        ];
        //dd($data);
        if (Auth::Attempt($data)) {
            return redirect('dashboard');
        }else{
            Session::flash('error', 'Email atau Password Salahhh');
            return redirect('/');
        }
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
