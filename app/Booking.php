<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public $incrementing = false;

    public function schedule()
    {
    	return $this->belongsTo('Schedule');
    }
}
