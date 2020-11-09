<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\DataException;
use App\Route;

class SearchRoutesController extends Controller
{
   /*public function index()
   {
    // $error = ['error' => 'City Not Found']; 

    //$routes = Route::with('cities')->get();
    $routes = Route::all();
    //dd($routes);
    if (!count($routes)) {     
      DataException::dataNotFoundFor('route');
    }
    return $routes;
   }*/

   public function index()
   {
   		return tap(Route::all(), function($routes) {
   			if (!count($routes)) {     
		    	DataException::dataNotFoundFor('route');
		    }
   		});
   }
}
