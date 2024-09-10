<?php

namespace App\models;

use App\models\Customer;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    protected $table = 'booking_details';
    protected $guarded = [];


    public function bookingGuest()
    {
        return $this->hasMany(BookingGuest::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function bookingGuests()
    {
        return $this->hasMany(BookingGuest::class);
    }

}