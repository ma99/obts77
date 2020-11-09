<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fare extends Model
{
    protected $guarded = [];

    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = serialize($value);
    }

    public function getDetailsAttribute($value)
    {   
        return unserialize($value);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function city_route()
    {
        return $this->belongsTo(CityRoute::class);
    }

    public function getFareBy($cityRouteId)
    {
        return $this->where('city_route_id', $cityRouteId)->first();
    }

    public function getFareByBus($type)
    {
        //$fare = json_decode($this->details, true); 
        $fare = json_decode(json_encode($this->details), true); 
        
        $result = $fare[$type] ?? 'N/A';        
        
        return $result;
    }        
}
