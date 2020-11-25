<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\City;

class CityController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store()
    {   
        $attributes = $this->validateRequest();

        return $city = City::create($attributes);    	 
    }

    public function destroy(City $city)
    {        
        $city->delete();
        return 'deleted';                    
    }

    protected function validateRequest()
    {
        return request()->validate([
           'division_id' => 'required',
           'district_id' => 'required',
           'name'  => [
                'required',
                Rule::unique('cities')->where(function ($query) {

                    return $query
                        ->where('district_id', $this->request->district_id);
                }),
            ]
        ],
        [
            'name.unique' => ':input city already exists!'
        ]);
    }
}