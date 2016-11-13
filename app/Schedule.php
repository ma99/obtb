<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function bookings()
    {
    	return $this->hasMany('Booking');
    }
}
