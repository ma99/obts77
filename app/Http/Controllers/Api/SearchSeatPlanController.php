<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\DataException;
use App\SeatPlan;

class SearchSeatPlanController extends Controller
{
   // public function index()
   // {
   //      $error = ['error' => 'No results found'];

   //      //$seatPlan = SeatPlan::latest()->get();
   //      $seatPlans = SeatPlan::cursor();
   //      return $seatPlans->count() ? $seatPlans : $error;        
        
   // }

	public function index()
   {
   		return tap(SeatPlan::cursor(), function($seatPlans) {
   			if (!count($seatPlans)) {     
		    	DataException::dataNotFoundFor('seatplan');
		    }
   		});
   }
}
