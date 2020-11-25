<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Rules\Uniqueness;
use App\Route;

class RouteController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function store()
    {        
        $attributes = $this->validateRequest();

        return Route::create($attributes);
    }

    public function update(Route $route)
    {
        $attributes = $this->validateRequest();

        $route->update($attributes);  

        return 'success';   
    }

    public function destroy(Route $route)
    {
        $error = ['error' => 'No results found'];
      
        if ($route) {
            $route->delete();
            return 'success';            
        }

        return $error;
    }

    // protected function validateRequest()
    // {
    //     return request()->validate(
    //         [
    //            'first_city' =>['required', 'max:50', new Uniqueness($this->request->second_city)],
    //            'second_city' => 'required|max:50',
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
               'first_city' =>[
                    'required', 
                    'max:50', 
                    new Uniqueness([
                        'field1' => 'first_city',
                        'field2' => 'second_city',
                        'modelName' => '\App\Route',
                        'param' => $this->request->second_city
                    ])
                ],
               'second_city' => 'required|max:50',
                'distance' => 'required|numeric|gt:0'
            ],
            [
                'distance.gt' => 'Distance must be a positive number.',
            ]
        );
    }
    
}
