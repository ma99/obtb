<?php
use 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/search', function(){
	   
	$from  = 'dhaka';
	$to = 'sylhet';
	// $route = \App\Rout::where('departure_city', $from)->
	// 				where( 'arrival_city', $to)->first();
	//$routeId= $route->id;

	//$email = DB::table('users')->where('name', 'John')->value('email');
	$routeId= \App\Rout::where('departure_city', $from)->
					where( 'arrival_city', $to)->value('id');
	
	//return($routeId);
	// all bookings with a particular route id
	//$schedules = \App\Schedule::where('rout_id', $routeId)->with(‘bookings’)->get();
	$schedules = \App\Schedule::where('rout_id', $routeId)->get();
	$sch = $schedules->load('bookings');

	return($sch);



});