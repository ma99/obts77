<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
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

    protected function validateRequest()
    {
        return request()->validate(
            [
               // 'first_city' => 'required|max:50',
               'first_city' => [
                   'required', 
                   'max:50',
                   Rule::unique('routes')->where(function($query) {
                    // return $query
                    //     ->where('first_city', $this->request->first_city)
                    //     ->where('second_city', $this->request->second_city);

                    // })
                    return $query
                        ->where(function($q) {                      
                           return $q->where('first_city', $this->request->first_city)
                                ->orWhere('second_city', $this->request->first_city);
                        })
                        ->where(function($q) {        
                           return $q->where('first_city', $this->request->second_city)
                                ->orWhere('second_city', $this->request->second_city);
                        });                

                    }),
                ],
               'second_city' => 'required|max:50',
                'distance' => 'required|numeric|gt:0'
            ],
            [
                'first_city.unique' => 'This route is already exists!',
                'distance.gt' => 'Distance must be a positive number.',
            ]
        );
    }
    
}
