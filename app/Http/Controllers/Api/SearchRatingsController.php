<?php

namespace App\Http\Controllers\Api;

use App\BusSchedule;
use App\CityRoute;
use App\Http\Controllers\Controller;
use App\Libraries\DataException;
use App\Services\Staff\Service;
use App\Supervisor;
use App\Trip;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Bus;


class SearchRatingsController extends Controller
{
	// private $busSchedule;
	// private $cityRoute;
	// private $trip;
	// private $staff;

	// public function __construct(BusSchedule $busSchedule,  CityRoute $cityRoute, Trip $trip, Service $staff)
	// {
	// 	$this->busSchedule = $busSchedule;
	// 	$this->cityRoute = $cityRoute;
	// 	$this->trip = $trip;
	// 	$this->staff = $staff;
	// }

 	public function index(Request $request)
   	{   		
   		
   		// /**	completed trips with ratings */
   		// // return $request->user()->load([
   		// // 	'trips' => function($q) {
   		// // 		$q->wherePivot('rating_done', 1);
   		// // 	}, 
   		// // 	'trips.ratingps'
   		// // ]);

   		// //////// Trip to be reviewed
   		// return $request->user()->load([
   		// 	'trips' => function($q) {
   		// 		$q->wherePivot('rating_done', 0)
   		// 		->where('status', 3);
   		// 	}, 	
   			
   		// ]);

   		
	   	// 	if (count($trips)) {		   		
		   // 		return [ 
		   			
		   // 		];   	
	   	// 	}
   		// }
   		//  return [
   		// 	'message' => 'Not Available',
   		// ];
    }
}
