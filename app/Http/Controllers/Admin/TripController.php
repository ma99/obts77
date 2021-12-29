<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trip;

class TripController extends Controller
{
	
	public function update(Trip $trip)
    {   
        $attributes = $this->validateRequest();

        
        $trip->update($attributes);

        return response()->json([
            'message' => 'success',
        ]);        
    }

	protected function validateRequest()
    {
        return request()->validate([
            'status' => 'required',
            'entry_by' => 'required'
        ]);
    }
	    
}
