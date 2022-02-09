<?php

namespace App\Http\Controllers;

use App\Services\Review\Service;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\TripUser;
use App\Review;

class ReviewController extends Controller
{
    private $request;
    private $review;

    public function __construct(Request $request, Service $service)
    {
        $this->request = $request;
        $this->review = $service;
    }    
    
    public function tripsReviewed() 
    {        
        return $this->review->getReviewedTripsBy($this->request->user());
    }

    public function tripsToBeReviewed()
    {
        return $this->review->getTripsToBeReviewedBy($this->request->user());
    }
        
    public function store($trip, TripUser $tripUser)
    {         
        $attributes = $this->validateRequest();
 
        return $this->review->store($trip, $tripUser, $attributes);

    }    

    protected function validateRequest()
    {        
        return request()->validate([
            '*.owner_id' => 'required|integer',
            '*.rate'    => 'required|integer|max:5',
            '*.owner_type' => [
                'required',
                Rule::unique('reviews')->where(function ($query) {
                return $query
                    ->where('trip_user_id', $this->request->tripUser->id);
                }),
            ],           
        ],
        [
            '*.owner_type.unique' => 'Already Reviewed!'
        ]);
    }
}
