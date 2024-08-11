<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;


class Booking extends Model
{
	protected $table = 'bookings';
	
	public function customer()
	{
		return $this->belongsTo(\App\Model\Customer::class);
	}
	
	public function room()
	{
		return $this->belongsTo('Room');
	}
}