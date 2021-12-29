<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class SeatDisplayController extends Controller
{
    // protected $user;

    public function __construct()
    {
        // $this->middleware('auth');
        // $this->user = $user;
    }


    public function index()
    {

        if (Auth::check()) {
            // The user is logged in...
            $user = Auth::user()->getUserInfo();            
            // dd($user);
            return view('pages.home', ['user' => json_encode($user)]);
        }

        $user= 'guest';

        return view('pages.home', compact('user'));
    }
}
