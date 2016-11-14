<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Booking;

class Schedule extends Model
{
    public function bookings()
    {
    	//return $this->hasMany('Booking');
    	return $this->hasMany(Booking::class);
    }
}
