<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $guarded = [];

    // public function routes()
    // {
    // 	return $this->belongsToMany(Route::class);
    // }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function schedules()
    {
    	return $this->belongsToMany(Schedule::class)
                    ->withPivot('id', 'departure_city_id')
                    ->withTimestamps(); 
    }

    public function busBy($id)
    {
        return $this->findOrFail($id);
    }

    // public function schedulesBy($routeId)
    // {
    //     //return $this->belongsToMany(Schedule::class)
    //     return $this->schedules()
    //                 ->wherePivot('route_id', $routeId);
    // }

    public function seat_plan()
    {
    	return $this->belongsTo(SeatPlan::class);//->latest();
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function drivers()
    {
        return $this->belongsToMany(Driver::class); 
    }

    public function supervisors()
    {
        return $this->belongsToMany(Supervisor::class); 
    }

    public function helpers()
    {
        return $this->belongsToMany(Helper::class); 
    } 

    public function addDriver($id)
    {
        return $this->drivers()->syncWithoutDetaching($id);
    }

    public function addHelper($id)
    {
        return $this->helpers()->syncWithoutDetaching($id);
    }

    public function addSupervisor($id)
    {
        return $this->supervisors()->syncWithoutDetaching($id);
    }

    public function removeDriver($id)
    {
        return $this->drivers()->detach($id);
    }

    public function removeHelper($id)
    {
        return $this->helpers()->detach($id);
    }

    public function removeSupervisor($id)
    {
        return $this->supervisors()->detach($id);
    }

    // public function typeBy($typeId)
    // {
    //     return $this->belongsTo(Type::class)
    //                 ->where('id', $typeId)->first();

    // }

    /*public function getBusesWithSeatPlan()
    {
        $buses = $this::with('seat_plan')->get();
        foreach ($buses as $bus) {           
            $busList[] = [
                'bus'   => $bus,
                'total_seats' => $bus->seat_plan->total_seats
            ];
        }
        return $busList;
    }*/
}
