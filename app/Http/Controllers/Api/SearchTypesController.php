<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\DataException;
use App\Type;

class SearchTypesController extends Controller
{
 	public function index()
   	{
   		return tap(type::all(), function($types) {
   			if (!count($types)) {     
		    	DataException::dataNotFoundFor('type');
		    }
   		});
    }

}
