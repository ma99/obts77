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

            $role = Auth::user()->getRole('name');
            $token = null;

            // $user = Auth::user();

           if (is_null($role)) {
                return view('errors.401', ['message' => 'Not Authorized']);
            } 
            if( $role == 'admin' || $role == 'super_admin' ) {               
                $token = Auth::user()->generateToken();
            }

            return view('dashboard.dashboard', [
                'role' => $role, 
                'token' => $token, 
                'user' => json_encode(Auth::user())
            ]);
        // }            
    }

    public function user()
    {
        $role = Auth::user()->getRole('name');
        // $user = Auth::user();

           if (is_null($role)) {
                return view('dashboard.dashboard', [
                    'role' => 'regular', 
                    'token' => null,
                    'user' => json_encode(Auth::user())
                ]);
            } 
        return redirect()->route('admin_dashboard');    
    }
}
