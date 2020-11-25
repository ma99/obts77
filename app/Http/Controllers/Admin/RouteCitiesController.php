<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\Uniqueness;

use App\City;
use App\Route;
use App\CityRoute;


class RouteCitiesController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store(Route $route)
    {
     
        $attributes = $this->validateRequest();
        
        $route->cities()->attach($attributes['first_city_id'], 
                        [
                            'second_city_id' => $attributes['second_city_id'],
                            'distance' => $attributes['distance']
                        ]);

        return $route->cities;
    }

    public function destroy(Route $route, CityRoute $routeCity)
    {
      
       $error = ['error' => 'No results found'];
      
        if ($routeCity) {
            $routeCity->delete();
            return $route->cities;          
        }
        return $error;        
    }

    // protected function validateRequest()
    // {
    //     return request()->validate(
    //         [
    //             'first_city_id' => 'required',
    //             'second_city_id' => 'required',
    //             'distance' => 'required|numeric|gt:0'
    //         ],
    //         [
    //             'distance.gt' => 'Distance must be a positive number.',
    //         ]   
    //     );
    // }    
    protected function validateRequest()
    {
        return request()->validate(
            [
                'first_city_id' => 'required',
                'first_city_id' => [
                    'required', 
                    new Uniqueness([
                        'field1' => 'first_city_id',
                        'field2' => 'second_city_id',
                        'modelName' => '\App\CityRoute',
                        'param' => $this->request->second_city_id
                    ])
                ],
                'second_city_id' => 'required',
                'distance' => 'required|numeric|gt:0'
            ],
            [
                'distance.gt' => 'Distance must be a positive number.',
            ]   
        );
    }    
}