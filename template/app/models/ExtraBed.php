<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ExtraBed extends Model
{
	protected $table = 'extra_beds';
	
	public function room()
	{
		return $this->belongsTo(Room);
	}
}