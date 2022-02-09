<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Arr;

class TripUser extends Pivot
{
    public $incrementing = true;

    public function reviews()
    {
        return $this->hasMany(Review::class, 'trip_user_id');
    }

    public function getUserReviewsBy($tripUserId)
    {        
        $tripUser = TripUser::findOrFail($tripUserId)->load('reviews');
        return Arr::except($tripUser->reviews, ['created_at', 'updated_at']);
    }

    public function createReviews(TripUser $tripUser, $attributes)
    {
        // return  $trip->reviews()->create([
        //     'rate' => $attribute['value'], 
        //     'owner_type' => "App\\{$attribute['type']}", 
        //     'owner_id' => $attribute['id']
        // ]);
        $reviews = [];
         foreach ($attributes as $attribute) {
            unset($attribute['text']);
           $reviews[] = $tripUser->reviews()->create($attribute);
           // $this->trip->createReview($trip, $attribute);
         }
        
         return $reviews; 
    }
    
}