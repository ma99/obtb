<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Bus;
use App\Rout;
use App\Fare;
use App\Schedule;
use Illuminate\Http\Request;

class SearchTicketController extends Controller
{
    public function searchTicket() {
    	$from  = 'dhaka';
		$to = 'sylhet';
		$date = '2016-12-30';
		
		$route = Rout::where('departure_city', $from)->
						where( 'arrival_city', $to)->first();
		
		$routeId= $route->id;
		//echo '5. fare = '. $route->fare;

		//$email = DB::table('users')->where('name', 'John')->value('email');
		/*$routeId= Rout::where('departure_city', $from)->
						where('arrival_city', $to)->value('id');*/
		
		//return($routeId);
		
		// all bookings with a particular route id		
		//$schedules = \App\Schedule::where('rout_id', $routeId)->with('bookings')->get();
		
		$schedules = Schedule::where('rout_id', $routeId)->
									with(['bookings' => function($query) use ($date) {
										$query->where('date', $date);
									}])->get();

		//echo $schedule->id;									

		//dd($schedules);
		$buses = [];
		foreach ($schedules as $schedule) {
			//echo $schedule->bus_id;
			//dd($schedule);
			//echo $schedule;
			// echo '1. Departure Time = ' . $schedule->departure_time;
			// echo '2. Arrival Time = ' . $schedule->arrival_time;


			$bus = Bus::where('id', $schedule->bus_id)->first();
			//echo ($bus);
			//dd($bus);
			$totalSeatsBooked = 0;
			$availableSeats = 0;
			
			//if ($schedule->bookings) {

			    foreach ($schedule->bookings as $booking) {

		     		//echo $booking->id;
		     		//$totalSeats = (int) $totalSeats + (int) $booking->seats;	     
		     		//echo $totalSeatsBooked;
		     		$totalSeatsBooked = $totalSeatsBooked + $booking->seats;   		     				     		
		     	}	
			
	        //echo 'SeatsBooked = ' . $totalSeatsBooked;
	        $availableSeats = $bus->total_seats - $totalSeatsBooked;

	        // echo '4. AvailableSeats = ' . $availableSeats;
	        // echo '3. Bus Type = ' . $bus->type;
	       
	        $bus_type = $bus->type;
	        //fare
	        if ($bus_type  == 'ac-deluxe') { 

			    $fare_ac = Fare::where('rout_id', $routeId)->
							 	 where('type', 'ac')->value('amount');


			     $fare_delux = Fare::where('rout_id', $routeId)->
									 where('type', 'deluxe')->value('amount');

				$fare = $fare_ac .'/'. $fare_delux ;
				
			}
			else 
				$fare = Fare::where('rout_id', $routeId)->
						  	  where('type', $bus_type)->value('amount');

			//echo '5. fare = '. $fare;
			$buses[] = [
				'departure_time' => $schedule->departure_time,
				'arrival_time' => $schedule->arrival_time,
				'bus_type' => $bus->type,
				'available_seats' => $availableSeats,
				'fare' => $fare
			];

		}
		// //dd($buses);
		//array of array to array of object 
		$buses = $object = json_decode(json_encode($buses), FALSE);
		
		foreach ($buses as $bus) {
		 	//echo $bus['fare'];
		 	echo $bus->fare;
		 	echo "\n";
		}
		//return($buses);	
    }
}
