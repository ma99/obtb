<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Schedule;

class Booking extends Model
{
   // protected $primaryKey = 'column_name';
    public $incrementing = false; 

    public function schedule()
    {
    	return $this->belongsTo(Schedule::class);
    	//return $this->belongsTo('Schedule'); don't work this way :(
    }

    public function seats()
    {
    	return $this->hasMany(Seat::class);
    	//return $this->belongsTo('Schedule'); don't work this way :(
    }
}
