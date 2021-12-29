<?php

namespace App\Http\Controllers\Api;

use App\Bus;
use App\BusSchedule;
use App\City;
use App\CityRoute;
use App\Http\Controllers\Controller;
use App\Libraries\DataException;
use App\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SearchTripsDetailsController extends Controller
{
   private $bus;
   private $schedule;
   private $city;
   private $cityRoute;

   public function __construct(Bus $bus, Schedule $schedule, City $city, CityRoute $cityRoute)
   {
      $this->bus = $bus;
      $this->schedule = $schedule;
      $this->city = $city;
      $this->cityRoute = $cityRoute;
   }

	public function index(BusSchedule $busschedule, CityRoute $cityRoute)
   {   		
      // dd('here');
      $bus = $this->bus->busBy($busschedule->bus_id);
      $schedule = $this->schedule->scheduleBy($busschedule->schedule_id);
      $departure_city = $this->city->cityBy($busschedule->departure_city_id)->name;
      $routeCity = $this->cityRoute->getArrivalCityBy($cityRoute->id, $busschedule->departure_city_id);
      $timeToAdd = (int)(($routeCity['distance']/65)*60);
      $dtO = Carbon::createFromFormat('H:i A', $schedule->departure_time);
      
      return [
         'bus' => $bus,
         'schedule' => $schedule,
         'departure_city' => $departure_city,
         'arrival_city' => $this->city->cityBy($routeCity['arrival_city_id'])->name,
         'distance' => $routeCity['distance'],
         // 'time_to_add' => $timeToAdd,
         'arrival_time' => $dtO->addMinutes($timeToAdd)->format('g:i A')
      ];
   }
}
