<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\DataException;
use App\CityRoute;
use App\Route;

class SearchRoutesCitiesController extends Controller
{
   // public function index()
   // {
   //  $error = ['error' => 'City Not Found']; 

   //  //$routes = Route::with('cities')->get();
   //  $routesCities = CityRoute::all();
   //  //dd($routes);
   //  return $routesCities->count() ? $routesCities : $error;
   // }

	public function index()
  {
 		return tap(CityRoute::all(), function($routeCities) {
 			if (!count($routeCities)) {     
	    	DataException::dataNotFoundFor('route-cities');
	    }
 		});
  }

  public function routeCities(Route $route)
   {
        if (!count($route->cities)) {     
          DataException::dataNotFoundFor('route-cities');
        }

        return $route->cities;
   }
}
