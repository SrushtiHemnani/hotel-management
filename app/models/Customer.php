<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static updateOrCreate( array $array, array $customerData )
 */
class Customer extends Model
{
	protected $table = 'customers';
	
	protected $fillable = ['name', 'email', 'phone', 'address', 'age'];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function bookingGuests()
    {
        return $this->hasMany(BookingGuest::class);
    }
}