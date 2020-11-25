<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('admin/{vue?}', function () {
//     return view('admin.admin');
// })->where('vue', '[\/\w\.-]*');//->middleware('auth', 'role:super_admin,admin');

Route::get('/admin/dashboard', function () {
    return view('dashboard.dashboard', ['role' => 'super_admin']);
});

Route::group(['middleware' => ['auth', 'role:super_admin']], function () {	
	//Route::delete('/bookings/{booking}', 'BookingController@destroy');    
	Route::post('/users/{user}/roles/{role}', 'Admin\Super\UserRoleController@store');
});

//Route::group(['middleware' => ['auth', 'role:super_admin,admin']], function () {
	
	//bus
	//Route::get('/bus/ids', 'Admin\BusController@busIds');
	//Route::get('/bus/{id}', 'Admin\BusController@showSeat');
	//Route::post('/bus/seatplan', 'Admin\BusController@storeSeatPlan');
	Route::post('/buses', 'Admin\BusController@store');
	Route::patch('/buses/{bus}', 'Admin\BusController@update');
	Route::delete('/buses/{bus}', 'Admin\BusController@destroy');

	//city
	Route::post('/cities', 'Admin\CityController@store');
	Route::delete('/cities/{city}', 'Admin\CityController@destroy');

	//stop
	Route::post('/stops', 'Admin\StopController@store');
	Route::delete('/stops/{stop}', 'Admin\StopController@destroy');

	//seat plan
	Route::post('/seatplans', 'Admin\SeatPlanController@store');
	Route::delete('/seatplans/{seatplan}', 'Admin\SeatPlanController@destroy');

	// type
	Route::post('/types', 'Admin\TypeController@store');
	Route::delete('/types/{type}', 'Admin\TypeController@destroy');

	//route
	Route::post('/routes', 'Admin\RouteController@store');
	Route::patch('/routes/{route}', 'Admin\RouteController@update');
	Route::delete('/routes/{route}', 'Admin\RouteController@destroy');

	//fare
	Route::post('/fares', 'Admin\FareController@store');
	Route::patch('/fares/{fare}', 'Admin\FareController@update');
	Route::delete('/fares/{fare}', 'Admin\FareController@destroy');

	//schedule 
	Route::post('/schedules', 'Admin\ScheduleController@store')->name('schedule');
	Route::delete('/schedules/{schedule}', 'Admin\ScheduleController@destroy');

	//bus route NOT USING ***** <======
	Route::post('/bus-route/{bus}', 'Admin\BusRouteController@store');
	Route::delete('/bus-route/{bus}/{route}', 'Admin\BusRouteController@destroy');
	//Route::post('/routes/{route}', 'Admin\RouteController@addBusesForRoute');
//=================>
	//bus schedule
	Route::post('/{bus}/schedules', 'Admin\BusSchedulesController@store');
	Route::delete('/bus-schedules/{bus}/{schedule}', 'Admin\BusSchedulesController@destroy');
	
	//route cities
	Route::post('/{route}/cities', 'Admin\RouteCitiesController@store');
	Route::delete('/route-cities/{route}/{routeCity}', 'Admin\RouteCitiesController@destroy');
//});	// end of group

Route::group(['middleware' => ['auth', 'role:super_admin,admin,operator']], function () {
	Route::get('/users/{phone}', 'Admin\UserController@index');
	Route::post('/bookings/byStaff/{user?}', 'BookingController@createByStaff');
	Route::post('/pay/cash', 'Payment\PaymentController@cash')->name('make.payment.cash');
});

Route::group(['middleware' => ['auth']], function () {
	// booking
	Route::post('/bookings', 'BookingController@store');
	Route::delete('/bookings/{booking}', 'BookingController@destroy');    
});


Route::get('/home', 'SearchTicketController@index')->name('home');//->middleware('verifiedphone'); 
Route::get('/search', 'SearchTicketController@searchTicket');
Route::get('/viewseats/buses/{bus}', 'SearchTicketController@viewSeats');

/** Phone Verification */
Route::get('phone/verify', 'PhoneVerificationController@show')->name('phoneverification.notice');
Route::post('phone/verify', 'PhoneVerificationController@verify')->name('phoneverification.verify');
Route::post('phone/resend', 'PhoneVerificationController@resend')->name('phoneverification.resend');

/** Reset Password by phone */

Route::get('password/reset/phone', 'Auth\ForgotPasswordController@showVerificationRequestForm')->name('password.request.phone');

Route::post('password/reset/sms', 'Auth\ForgotPasswordController@sendVerificationCodeSms')->name('password.send.sms');

// Route::get('password/verify/phone', 'Auth\ForgotPasswordController@showVerificationSubmitForm')->name('password.verify.show');
Route::get('password/verify', 'Auth\ForgotPasswordController@showVerificationSubmitForm')->name('password.verify.show');
Route::post('password/verify/phone', 'Auth\ForgotPasswordController@verify')->name('password.verify.phone');

Route::get('password/reset/phone/{token}', 'Auth\ResetPasswordController@showPhoneResetForm')->name('password.reset.phone');
Route::post('password/reset/phone', 'Auth\ResetPasswordController@resetByPhone')->name('password.update.phone');

//Route::post('password/phone', 'Auth\ForgotPasswordController@showPhoneRequestForm')->name('phone.password.request');

/*Payment*/
//Route::post('/pay/{booking}', 'Payment\PaymentController@index')->name('make.payment');
//Route::post('/pay', 'Payment\PaymentController@cash')->name('make.payment.cash'); //shifted to admin grps
Route::post('/pay/card', 'Payment\PaymentController@card')->name('make.payment.card');
Route::post('/payment/success', 'Payment\PaymentController@success');
Route::post('/payment/fail', 'Payment\PaymentController@fail');
Route::post('/payment/cancel', 'Payment\PaymentController@cancel');
Route::post('/payment/ipn', 'Payment\PaymentController@ipn');

Route::get('/lara-home', 'HomeController@index')->name('lara-home');

Route::get('/map', function() {
	return view('map-stops');
});

Auth::routes();

\DB::listen(function($sql) {
    \Log::info($sql->sql);
    \Log::info($sql->bindings);
    \Log::info($sql->time);
});