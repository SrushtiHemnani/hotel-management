<?php

require __DIR__ . '/../../bootstrap/bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('users', function (Blueprint $table) {
	$table->increments('id')->primary();
	$table->string('name');
	$table->string('email')->unique();
	$table->string('password');
	$table->timestamps();
});

Capsule::schema()->create('rooms', function (Blueprint $table) {
	$table->increments('id')->primary();
	$table->string('room_type');
	$table->string('room_price');
	$table->integer('capacity');
	$table->integer('room_count')->default(10);
	$table->boolean('is_extra')->default(0);
	$table->timestamps();
});


Capsule::schema()->create('customers', function (Blueprint $table) {
	$table->increments('id')->primary();
	$table->string('name');
	$table->string('email');
	$table->string('phone');
	$table->integer('age');
	$table->string('address')->nullable();
	$table->timestamps();
});
Capsule::schema()->create('guests', function (Blueprint $table) {
	$table->increments('id');
	$table->unsignedInteger('customer_id');
	$table->string('name');
	$table->integer('age');
	$table->timestamps();
	
	$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
});


Capsule::schema()->create('bookings', function (Blueprint $table) {
	$table->increments('id')->primary();
	$table->unsignedInteger('customer_id');
	$table->unsignedInteger('room_id');
	$table->string('room_number');
	$table->string('room_type');
	$table->string('room_price');
	$table->string('check_in');
	$table->string('check_out');
	$table->string('total_price');
	$table->unsignedInteger('parent_id')->nullable();
	$table->timestamps();
	
	$table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
	$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
	$table->foreign('parent_id')->references('id')->on('bookings')->onDelete('cascade');
});

Capsule::schema()->create('booking_guest', function (Blueprint $table) {
	$table->increments('id');
	$table->unsignedInteger('booking_id');
	$table->unsignedInteger('guest_id');
	$table->timestamps();
	
	$table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
	$table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');
});

//
//INSERT INTO rooms (room_type, room_price, capacity, is_extra)
//VALUES
//('SINGLE_ROOM', 1500, 1, 0),
//('DOUBLE_ROOM', 2000, 2, 0),
//('TRIPLE_ROOM', 2750, 3, 0),
//('EXTRA_BED', 500, 1, 1);