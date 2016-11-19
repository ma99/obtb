<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Bus;
use App\Rout;
use App\Schedule;
use Illuminate\Http\Request;

class SearchTicketController extends Controller
{
    public function searchTicket() {
    	$from  = 'dhaka';
		$to = 'sylhet';
		$date = '2016-11-30';
		// $route = \App\Rout::where('departure_city', $from)->
		// 				where( 'arrival_city', $to)->first();
		//$routeId= $route->id;

		//$email = DB::table('users')->where('name', 'John')->value('email');
		$routeId= Rout::where('departure_city', $from)->
						where('arrival_city', $to)->value('id');
		
		//return($routeId);
		
		// all bookings with a particular route id		
		//$schedules = \App\Schedule::where('rout_id', $routeId)->with('bookings')->get();
		
		$schedules = \App\Schedule::where('rout_id', $routeId)->
									with(['bookings' => function($query) use ($date) {
										$query->where('date', $date);
									}])->get();

		//echo $schedule->id;									
				
		foreach ($schedules as $schedule) {			//echo $schedule->bus_id;
			$bus = Bus::where('id', $schedule->bus_id)->first();
			//echo ($bus);

			$totalSeatsBooked = 0;
			$availableSeats = 0;

		    foreach ($schedule->bookings as $booking) {
	     		//echo $booking->id;
	     		//$totalSeats = (int) $totalSeats + (int) $booking->seats;	     		
	     		$totalSeatsBooked = $totalSeatsBooked + $booking->seats;     				     		
	     	}	
	        echo 'SeatsBooked = ' . $totalSeatsBooked;
	        $availableSeats = $bus->total_seats - $totalSeatsBooked;

	        echo '4. AvailableSeats = ' . $availableSeats;
	        echo '3. Bus Type = ' . $bus->type;

	        //fare
	        if ($bus_type  == 'ac_delux') { 

			    $fare_ac = Fare::where('rout_id', $routeId)->
								 where('type', 'ac')->value('amount');


			     $fare_delux = Fare::where('rout_id', $routeId)->
									 where('type', 'delux')->value('amount');

				$fare = $fare_ac .'/'. $fare_delux ;
			}
			else 
			$fare = Fare::where('rout_id', $routeId)->
						  where('type', $bus_type)->value('amount');
		}
		
		//return($schedules);	
    }
}
