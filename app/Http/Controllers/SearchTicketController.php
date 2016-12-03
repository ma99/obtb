<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Bus;
use App\Rout;
use App\Fare;
use App\Seat;
use App\Schedule;
use Illuminate\Http\Request;

class SearchTicketController extends Controller
{
    protected $schedules;
    //protected $seatsByBooking = [];

    public function searchTicket() {
    	$from  = 'dhaka';
		$to = 'sylhet';
		$date = '2016-12-30';
		
		$route = Rout::where('departure_city', $from)->
						where( 'arrival_city', $to)->first();
		
		$routeId= $route->id;
		
		$schedules = Schedule::where('rout_id', $routeId)->
									with(['bookings' => function($query) use ($date) {
										$query->where('date', $date);
									}])->get();		
		//$buses = [];		
		$scheduleId = 1;
		foreach ($schedules as $schedule) {

			$seatsByBooking[] = $this->seatsByBooking($schedule, $scheduleId);
			//return $seatsByBooking;
			$bus = Bus::where('id', $schedule->bus_id)->first();			
			$totalSeatsBooked = 0;
			$availableSeats = 0;

		    foreach ($schedule->bookings as $booking) {
	     		$totalSeatsBooked = $totalSeatsBooked + $booking->seats;   		     				     		
	     	}	
	        //echo 'SeatsBooked = ' . $totalSeatsBooked;
	        $availableSeats = $bus->total_seats - $totalSeatsBooked;
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

		$buses = $object = json_decode(json_encode($buses), FALSE);		
		// foreach ($buses as $bus) {
		//  	//echo $bus['fare'];
		//  	echo $bus->fare;
		//  	echo "\n";
		// }
		//return $seatsByBooking;
		return $buses; 
    }

    public function seatsByBooking($schedule, $scheduleId) {
    		// dd($schedule);
	        //foreach ($this->schedules as $schedule) {
		        if ($schedule->id == $scheduleId) {

					foreach ($schedule->bookings as $booking) {
						$seats = Seat::where('booking_id', $booking->id)->get(); //collection
						foreach ($seats as $seat) {
							$arr_seats[] = [
								'seat_no' => $seat->seat_no,
								'status'  => $seat->status 	 
							];
						}
						//return $arr_seats; 
					}
					return $arr_seats; 
				}
			//}	
    }
}
