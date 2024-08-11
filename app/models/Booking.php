<?php

namespace App\models;

use App\models\Customer;
use Illuminate\Database\Eloquent\Model;


class Booking extends Model
{
	protected $table = 'bookings';
	protected $guarded = [];
	
	public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function rooms()
    {
        return $this->belongsTo(Room::class , 'room_id' , 'id'  );
    }
	
}