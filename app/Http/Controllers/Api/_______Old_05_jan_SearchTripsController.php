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
	   		$drivers = [];
	   		$helpers = [];
	   		foreach ($buses as $bus) {
	   			$busSchedules = $this->busSchedule->getBusSchedulesBy($bus);
	   			$drivers[] = $bus->drivers;
	   			$helpers[] = $bus->helpers;
	   			foreach ($busSchedules as $busSchedule) {
	   				foreach ($busSchedule->pendingTrips as $trip) {
	   					$trips[] = $trip;
	   				}
	   			}
	   		}   		
	   		if (count($trips)) {		   		
		   		// return $this->busSchedule->sortByBusSchedule(collect($trips));
		   		return [ 
		   			'trips' => 
		   		 $this->cityRoute->sortByRouteCityDistance(collect($trips)),
		   			'drivers' => $drivers,
		   			'helpers' => $helpers
		   		];
		   		/*$tripsInfo['trips'] = $this->cityRoute->sortByRouteCityDistance(collect($trips));
		   		$tripsInfo['drivers'] = $drivers;
		   		$tripsInfo['helpers'] = $helpers;

		   		return $tripsInfo;*/
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
