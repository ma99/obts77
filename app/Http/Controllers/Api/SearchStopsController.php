<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\DataException;
use App\Stop;

class SearchStopsController extends Controller
{
   // public function index()
   // {
   //  $error = ['error' => 'City Not Found']; 

   //  $stops = Stop::all();
   //  return $stops->count() ? $stops : $error;
   // }

	public function index()
   {
   		return tap(Stop::cursor(), function($stops) {
   			if (!count($stops)) {     
		    	DataException::dataNotFoundFor('stop');
		    }
   		});
   }

}
