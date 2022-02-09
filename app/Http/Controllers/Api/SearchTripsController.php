<?php

namespace App\Http\Controllers\Api;

use App\BusSchedule;
use App\City;
use App\CityRoute;
use App\Http\Controllers\Controller;
use App\Libraries\DataException;
use App\Services\Staff\Service;
use App\Supervisor;
use App\Trip;
use App\User;
use Illuminate\Http\Request;
// use App\Bus;


class SearchTripsController extends Controller
{
	private $cityRoute;
	private $trip;
	private $staff;
	private $city;

	public function __construct(CityRoute $cityRoute, Trip $trip, Service $staff, City $city)
	{
		$this->cityRoute = $cityRoute;
		$this->trip = $trip;
		$this->staff = $staff;
		$this->city = $city;
	}

 	public function index(User $user)
   	{   		
   		// $buses = optional($user->supervisor)->buses; 		
   		// $buses = $this->getBusesBy(optional($user->supervisor));
   		$buses = $this->getBusesBy(optional($user->supervisor));
   		
   		if($buses !== null) {   			
	   		$trips = [];
	   		$drivers;
	   		$helpers;
	   		// ddd($buses->load('schedules'));
	   		// $buses = $buses->load('schedules');
	   		foreach ($buses as $bus) {
	   			// $busSchedules = $this->busSchedule->getBusSchedulesBy($bus);
	   			$drivers = $this->staff->detailsOf($bus->drivers);
	   			$helpers = $this->staff->detailsOf($bus->helpers);

	   			// foreach ($busSchedules as $busSchedule) {
	   			foreach ($bus->schedules as $schedule) {   				  
	   				foreach ($schedule->pivot->pendingTrips as $trip) {
	   					$trips[] = $this->trip->tripDetails($trip);
	   				}
	   			}
	   		}   		
	   		if (count($trips)) {		   		
		   		return [ 
		   			'trips' => 
		   		 $this->cityRoute->sortByRouteCityDistance(collect($trips)),
		   			'drivers' => $drivers,
		   			'supervisor' => $user->supervisor->id,
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

    /*public function tripRouteCitites(CityRoute $cityRoute, BusSchedule $busSchedule)
    {
    	$arrivalCityId = $cityRoute->getArrivalCityBy($cityRoute->id, $busSchedule->departure_city_id);
    	
    	$arrivalCityName = $this->city->cityBy($arrivalCityId)->name;

    	$departureCityName = $this->city->cityBy($busSchedule->departure_city_id)->name;

    	return "{$departureCityName} to {$arrivalCityName}";
    }*/

    public function trips()
    {
    	return tap(Trip::all(), function($trips) {
   			if (!count($trips)) {     
		    	DataException::dataNotFoundFor('trip');
		    }
   		});   		
    }

    public function getBusesBy($supervisor)
    {
    	// return $supervisor->buses ?? null;   
    	return optional($supervisor->load('buses.schedules'))->buses;   
    }

}
