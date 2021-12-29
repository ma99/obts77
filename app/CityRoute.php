<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CityRoute extends Pivot
{
    //
    public $incrementing = true;

    public function fare()
    {
        return $this->hasOne(Fare::class, 'city_route_id');
    }

    public function sortByRouteCityDistance($collection)
    {
        // $collection;
        return $collection->sort(function ($a, $b) {

            $dt1 = $this::findOrFail($a->city_route_id)->distance;
            
            $dt2 = $this::findOrFail($b->city_route_id)->distance;

            return ($dt1 - $dt2);
        })->values()->all();   
    }

    public function getCityRouteBy($departure_city, $arrival_city)
    {
        return CityRoute::where(function($query) use ($departure_city) {
            $query->where('first_city_id', $departure_city)
                ->orWhere('second_city_id', $departure_city);
        })
        ->where(function($query) use ($arrival_city)    {
            $query->where('first_city_id', $arrival_city)
                ->orWhere('second_city_id', $arrival_city);
        })
        ->first();
    }

    public function getArrivalCityBy($cityRouteId, $departureCityId)
    {
        $city = $this->findOrFail($cityRouteId);

        if ($departureCityId === $city->first_city_id) {
             return [
                'arrival_city_id' =>  $city->second_city_id,
                'distance' =>  $city->distance,
             ];
         }

         return [
            'arrival_city_id' =>  $city->first_city_id,
            'distance' =>  $city->distance,
         ]; 
    }
}