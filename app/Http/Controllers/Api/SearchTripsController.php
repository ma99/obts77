<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\DataException;
use Illuminate\Http\Request;
use App\BusSchedule;
use App\Supervisor;
use App\CityRoute;
use App\Trip;
use App\User;
// use App\Bus;


class SearchTripsController extends Controller
{
	private $busSchedule;
	private $cityRoute;

	public function __construct(BusSchedule $busSchedule,  CityRoute $cityRoute)
	{
		$this->busSchedule = $busSchedule;
		$this->cityRoute = $cityRoute;
	}

 	public function index(User $user)
   	{   		
   		// $buses = optional($user->supervisor)->buses; 		
   		$buses = $this->getBusesBy(optional($user->supervisor));

   		if($buses !== null) {   			
	   		$trips = [];
	   		foreach ($buses as $bus) {
	   			$busSchedules = $this->busSchedule->getBusSchedulesBy($bus);
	   			foreach ($busSchedules as $busSchedule) {
	   				foreach ($busSchedule->pendingTrips as $trip) {
	   					$trips[] = $trip;
	   				}
	   			}
	   		}   		
	   		if (count($trips)) {		   		
		   		// return $this->busSchedule->sortByBusSchedule(collect($trips));
		   		return $this->cityRoute->sortByRouteCityDistance(collect($trips));
	   		}
   		}
   		return [
   			'message' => 'Not Available',
   		];
    }

    public function trips()
    {
    	return tap(trip::all(), function($trips) {
   			if (!count($trips)) {     
		    	DataException::dataNotFoundFor('trip');
		    }
   		});   		
    }

    public function getBusesBy($supervisor)
    {
    	return $supervisor->buses ?? null;   
    }

}
