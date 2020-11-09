<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\DataException;

use App\District;

class SearchDistrictsController extends Controller
{
   // public function index()
   // {
   //  $error = ['error' => 'City Not Found']; 

   //  $districts = District::all();
   //  return $districts->count() ? $districts : $error;
   // }

	public function index()
   {
   		return tap(District::all(), function($districts) {
   			if (!count($districts)) {     
		    	DataException::dataNotFoundFor('district');
		    }
   		});
   }
}
