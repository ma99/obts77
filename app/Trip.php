<?php

namespace App;

use App\Bus;
use App\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Trip extends Model
{
    protected $guarded = [];
    protected $bus;
    private $schedule;
    private $city;
    private $cityRoute;

    const TYPE_MAIN = 1;
    const TYPE_SUB = 2;

    const STATUS_PENDING = 1;
    const STATUS_CANCELLED = 2;
    const STATUS_COMPLETED = 3;

    public function __construct(array $attributes = [])
    {
         parent::__construct($attributes);

         $this->createAndAssignInstences();        
    }

    public function createAndAssignInstences()
    {
        $this->bus = new Bus();
        $this->schedule = new Schedule();
        // $this->busSchedule = new BusSchedule();
        $this->city = new City();
        $this->cityRoute = new cityRoute();
    }
    
    public function setDateAttribute($value)
    {
        return $this->attributes['date'] = date("Y-m-d", strtotime($value));
    }

    public function getDateAttribute($value)
    {
        return date("d-m-Y", strtotime($value));
    }
        
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /*public function createReviews(Trip $trip, $attributes)
    {
        // return  $trip->reviews()->create([
        //     'rate' => $attribute['value'], 
        //     'owner_type' => "App\\{$attribute['type']}", 
        //     'owner_id' => $attribute['id']
        // ]);
        $reviews = [];
         foreach ($attributes as $attribute) {
            unset($attribute['text']);
           $reviews[] = $trip->reviews()->create($attribute);
           // $this->trip->createReview($trip, $attribute);
         }
        
         return $reviews; 
    }*/

    public function users()
    {
        return $this->belongsToMany(User::class); 
    }

    public function createIfNotExists($attributes)
    {
        // $type = $this->tripType($attributes['city_route_id']);

        return Trip::firstOrCreate([
            'bus_schedule_id' => $attributes['bus_schedule_id'], 
            'city_route_id' => $attributes['city_route_id'], 
            'date' => $attributes['date'],
            'type' => $this->tripType($attributes['city_route_id'])
        ]);
    }

    // public static function getTypeMainValue()
    // {
    //     return self::TYPE_MAIN;
    // }

    // public static function getTypeSubValue()
    // {
    //     return self::TYPE_SUB;
    // }

    public function tripType($cityRouteId)
    {
        $cityRoute = $this->cityRoute->infoBy($cityRouteId);
        $route = Route::findOrFail($cityRoute->route_id);
        $cityRouteCities = [
            'first_city' => $this->city->cityBy($cityRoute->first_city_id)->name,
            'second_city' => $this->city->cityBy($cityRoute->second_city_id)->name
        ];
        return $this->cityRoute->areCityRouteCitiesSameAsRouteCities($cityRouteCities, $route) ? self::TYPE_MAIN : self::TYPE_SUB ;
    }

    public function pendingTripBy($busScheduleId, $date)
    {
        // $date = date("Y-m-d", strtotime($date));
        return $trip = Trip::where('bus_schedule_id', $busScheduleId)
                    ->where('date', $date)
                    ->where('status', self::STATUS_PENDING)
                    ->first();
    }

    public function status($id)
    {
        return $this->findOrFail($id)->status;
    }

    public function convertToReadable($statusValue)
    {
        return collect([
         '1' => 'Pending', 
         '2' => 'Cancelled',
         '3' => 'Completed'
        ])->first(function($value, $key) use ($statusValue) {
            return $key === $statusValue;
        });
    }

    public function tripDetails(Trip $trip)
    {
        $busSchedule = BusSchedule::findOrFail($trip->bus_schedule_id);
        $cityRoute = cityRoute::findOrFail($trip->city_route_id);

        $bus = $this->bus->busBy($busSchedule->bus_id);
        
        $schedule = $this->schedule->scheduleBy($busSchedule->schedule_id);
        
        $departure_city = $this->city->cityBy($busSchedule->departure_city_id)->name;
        
        $arrivalCityId = $this->cityRoute->getArrivalCityBy($cityRoute->id, $busSchedule->departure_city_id);
        
        $timeToAdd = (int)(($cityRoute->distance/65)*60);

        $dtO = Carbon::createFromFormat('H:i A', $schedule->departure_time);
          
        return [
            'id' => $trip->id,
            'bus_schedule_id' => $trip->bus_schedule_id,
            'date' => $trip->date,
            'status' => $this->convertToReadable($trip->status),
            'bus' => $bus,
            'schedule' => $schedule,
            'departure_city' => $departure_city,
            'arrival_city' => $this->city->cityBy($arrivalCityId)->name,
            'distance' => $cityRoute->distance,
            // 'time_to_add' => $timeToAdd,
            'arrival_time' => $dtO->addMinutes($timeToAdd)->format('g:i A')
        ];
    }


    // public function tripRouteCitites(CityRoute $cityRoute, BusSchedule $busSchedule)
    public function tripRouteCities($city_route_id, $bus_schedule_id)
    {
        $cityRoute = cityRoute::findOrFail($city_route_id);
        $busSchedule = BusSchedule::findOrFail($bus_schedule_id);

        $arrivalCityId = $cityRoute->getArrivalCityBy($cityRoute->id, $busSchedule->departure_city_id);
        
        $arrivalCityName = $this->city->cityBy($arrivalCityId)->name;

        $departureCityName = $this->city->cityBy($busSchedule->departure_city_id)->name;

        $schedule = $this->schedule->scheduleBy($busSchedule->schedule_id);

        return [
            'route_cities' => "{$departureCityName} to {$arrivalCityName}",
            'departure_time' => $schedule->departure_time
        ];
    }    
}
