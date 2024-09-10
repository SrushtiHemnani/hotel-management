<?php

namespace App\models;

use App\models\Customer;
use Illuminate\Database\Eloquent\Model;


/**
 * @method booking_guest()
 */
class Booking extends Model
{
    protected $table = 'bookings';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function bookingDetail()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function guests()
    {
        return $this->belongsToMany(Guest::class, 'booking_guest');
    }


    public function bookingGuest()
    {
        return $this->hasMany(BookingGuest::class);
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

}