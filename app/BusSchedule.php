<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BusSchedule extends Pivot
{
    public $incrementing = true;

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'bus_schedule_id');
    }
    
    public function trips()
    {
        return $this->hasMany(Trip::class, 'bus_schedule_id');
    }

    public function pendingTrips()
    {
        return $this->hasMany(Trip::class, 'bus_schedule_id')
            ->where('date', date("Y-m-d"))
            ->where('status', 'Pending');
    }

    /*public function sortByBusSchedule($collection)
    {
        return $collection->sort(function ($a, $b) {
                
            $st1 = \App\Schedule::findOrFail($this->getBusScheduleBy($a->bus_schedule_id)->schedule_id)->departure_time;
            
            $st2 = \App\Schedule::findOrFail($this->getBusScheduleBy($b->bus_schedule_id)->schedule_id)->departure_time;

                return (strtotime($st1) - strtotime($st2));
        })->values()->all();
    }*/

    
    public function getBusSchedulesBy($bus)
    {
        return BusSchedule::where('bus_id', $bus->id)
                            // ->where('status', 'Pending')
                            ->get();
    }

    public function getBusScheduleBy($id)
    {
        return $this->findOrFail($id); 
    }    
    
}