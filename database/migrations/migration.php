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
	$table->string('room_number');
	$table->string('room_type');
	$table->string('room_price');
	$table->timestamps();
});

Capsule::schema()->create('bookings', function (Blueprint $table) {
	$table->increments('id')->primary();
	$table->string('room_number');
	$table->string('room_type');
	$table->string('room_price');
	$table->string('check_in');
	$table->string('check_out');
	$table->string('total_price');
	$table->timestamps();
});

Capsule::schema()->create('customers', function (Blueprint $table) {
	$table->increments('id')->primary();
	$table->string('name');
	$table->string('email');
	$table->string('phone');
	$table->string('address');
	$table->timestamps();
});
Capsule::schema()->create('guests', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->string('email')->unique();
    $table->string('phone');
    $table->timestamps();
});

Capsule::schema()->create('room_bookings', function (Blueprint $table) {
	$table->increments('id')->primary();
	$table->string('room_id');
	$table->string('booking_id');
	$table->timestamps();
});

Capsule::schema()->create('extra_beds', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('room_id');
    $table->timestamps();

    $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
});

