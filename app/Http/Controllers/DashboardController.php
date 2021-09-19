<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\User;

class DashboardController extends Controller
{
    // protected $user;

    public function __construct()
    {
        $this->middleware('auth');
        // $this->user = $user;
    }


    public function admin()
    {

        // if (Auth::check()) {
            // The user is logged in...

            $role = Auth::user()->getRole();

           if (is_null($role)) {
                return view('errors.401', ['message' => 'Not Authorized']);
                // return 'you are not authorized';
            } 

            return view('dashboard.dashboard', ['role' => $role]);
        // }            
    }

    public function user()
    {
        $role = Auth::user()->getRole();

           if (is_null($role)) {
                return view('dashboard.dashboard', ['role' => 'regular']);
            } 
        return redirect()->route('admin_dashboard');    
    }
}