<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//bus
//Route::get('/bus', 'Api\SearchBusController@busInfo');
Route::get('/buses/{bus}', function(App\Bus $bus) {
 	return $bus->route->cities()->get();
 	//return $bus->route->load('cities');
});
Route::get('/{bus}/ss', function(App\Bus $bus) {
 	//return $bus->schedules()->get();
 	return $bus->load('schedules');
});


Route::get('/buses', 'Api\SearchBusesController@index');
Route::get('/types', 'Api\SearchTypesController@index');
Route::get('/routes', 'Api\SearchRoutesController@index');
Route::get('/fares', 'Api\SearchFaresController@index');
Route::get('/stops', 'Api\SearchStopsController@index');

//schedule
Route::get('/schedules', 'Api\SearchSchedulesController@index');
Route::get('/{bus}/schedules', 'Api\SearchSchedulesController@busSchedules');

//seat plan
Route::get('/seatplans', 'Api\SearchSeatPlanController@index');

Route::get('/divisions', 'Api\SearchDivisionsController@index');
Route::get('/districts', 'Api\SearchDistrictsController@index');
Route::get('/upazilas', 'Api\SearchUpazilasController@index');
Route::get('/cities', 'Api\SearchCitiesController@index');
Route::get('/{route}/cities', 'Api\SearchCitiesController@routeCities');

//city

Route::get('/city', 'Api\SearchCitiesController@cityTo');
Route::get('/pickup', 'Api\SearchCitiesController@pickupPoints');
Route::get('/dropping', 'Api\SearchCitiesController@droppingPoints');

// Routes Cities
Route::get('/route-cities', 'Api\SearchRoutesCitiesController@index');
