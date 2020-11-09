<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Bus;

class BusController extends Controller
{
    
    public function store()
    {        
        $attributes = $this->validateRequest();
        
        $bus = Bus::create($attributes);

        return $bus;
    }

    public function update(Bus $bus)
    {   
        $attributes = $this->validateRequest();

        $bus->update($attributes);

        // return 'success';
        
        return response()->json([
            'status' => 'success',
        ]);
    }

    public function destroy(Bus $bus)
    {
        $error = ['error' => 'No results found'];

        if ($bus) {
            $bus->delete();
            return 'success';            
        }
        return $error;
    }

    protected function validateRequest()
    {
        return request()->validate([
        	'route_id' => 'required',
            'seat_plan_id' => 'required',
            'type_id' => 'required',
            'reg_no' => 'required|max:50',
            'number_plate' => 'required',
            'description' => 'nullable'
        ]);
    }
}