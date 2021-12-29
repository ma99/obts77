<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $guarded = [];
    
    public function setDateAttribute($value)
    {
        return $this->attributes['date'] = date("Y-m-d", strtotime($value));
    }

    public function getDateAttribute($value)
    {
        return date("d-m-Y", strtotime($value));
    }

    public function createIfNotExistBy($bus_schedule_id, $city_route_id,  $date)
    {
        Trip::firstOrCreate([
            'bus_schedule_id' => $bus_schedule_id, 
            'city_route_id' => $city_route_id, 
            'date' => $date
        ]);
    }

    public function pendingTripBy($busScheduleId, $date)
    {
        // $date = date("Y-m-d", strtotime($date));
        return $trip = Trip::where('bus_schedule_id', $busScheduleId)
                    ->where('date', $date)
                    ->where('status', 'Pending')                  
                    ->first();
    }

    
}
