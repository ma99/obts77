<?php

namespace App\Services\Review;

use App\Review;
use App\Trip;
use App\TripUser;
use App\User;
use Illuminate\Support\Arr;
// use Illuminate\Http\Request;

class Service 
{
	private $trip;
	private $tripUser;

	public function __construct(Trip $trip , TripUser $tripUser)
	{
		$this->trip = $trip;
		$this->tripUser = $tripUser;
	}

    public function getReviewedTripsBy(User $user)
    {
    	// $u = $request->user()->load([
    	$u = $user->load([
     		'trips' => function($q) {
         		$q->wherePivot('reviewed', Review::REVIEWED_YES);
     		},          
        ]);
    	// ddd($u);
    	return $this->details($u->trips->toArray());
    }

    public function getTripsToBeReviewedBy(User $user) {
    	$u = $user->load([
            'trips' => function($q) {
                $q->wherePivot('reviewed', Review::REVIEWED_NO)
                ->where('status', $this->trip::STATUS_COMPLETED);
            },              
        ]);
        return $this->details($u->trips->toArray());
    }

    public function details(array $trips)
    {
        $modifiedTrips = [];
		// ddd($trips);
        foreach ($trips as $trip) {
            $routeCities = $this->trip->tripRouteCities($trip['city_route_id'], $trip['bus_schedule_id']);
            // $tripUser = $this->tripUser->getUserReviewsBy($trip['pivot']['id']);
            // ddd($tripUser);
            // array_push($trip, $routeCities);
            $trip['reviews'] = $this->tripUser->getUserReviewsBy($trip['pivot']['id']);
            $trip['route_cities'] = $routeCities['route_cities'];
            $trip['departure_time'] = $routeCities['departure_time'];
            // $modifiedTrips[] = $trip;
            $modifiedTrips[] = Arr::except($trip, ['bus_schedule_id', 'city_route_id', 'type', 'status', 'created_at', 'updated_at' ]);
         } 
         return $modifiedTrips;
    }

    public function store($tripId, TripUser $tripUser, array $attributes)
    {        
        $reviews = $this->tripUser->createReviews($tripUser, $attributes);

        if($reviews) {
             auth()->user()->tripReviewCompleted($tripId); 
             return $reviews;
        }
        return [
            'message' => 'Something went wrong!',
        ];
    }

}