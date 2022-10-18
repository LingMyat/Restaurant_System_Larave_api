<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginPage(){
        return view('login');
    }
    //
    public function registerPage(){
        return view('register');
    }

    public function dashboard(){
        if (auth()->user()->role == 'admin') {
            return to_route('dish#index');
        } elseif(auth()->user()->role == 'waiter') {
            return to_route('order#index');
        }
    }
}
