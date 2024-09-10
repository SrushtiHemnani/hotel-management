<?php

require __DIR__ . '/../../bootstrap/bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

// Drop all tables if they exist
Capsule::schema()->dropIfExists('booking_guest');
Capsule::schema()->dropIfExists('booking_details');
Capsule::schema()->dropIfExists('bookings');
Capsule::schema()->dropIfExists('guests');
Capsule::schema()->dropIfExists('customers');
Capsule::schema()->dropIfExists('rooms');
Capsule::schema()->dropIfExists('users');

// Create 'users' table
Capsule::schema()->create('users', function (Blueprint $table) {
    $table->increments('id')->primary();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->enum('role', ['admin', 'user'])->default('user');
    $table->timestamps();
});

// Create 'rooms' table
Capsule::schema()->create('rooms', function (Blueprint $table) {
    $table->increments('id')->primary();
    $table->string('room_type');
    $table->string('room_price');
    $table->integer('capacity');
    $table->integer('room_count')->default(10);
    $table->boolean('is_extra')->default(0);
    $table->timestamps();
});

// Insert default room types if they do not exist
Capsule::table('rooms')->insertOrIgnore([
    ['room_type' => 'SINGLE_ROOM', 'room_price' => 1500, 'capacity' => 1, 'is_extra' => 0],
    ['room_type' => 'DOUBLE_ROOM', 'room_price' => 2000, 'capacity' => 2, 'is_extra' => 0],
    ['room_type' => 'TRIPLE_ROOM', 'room_price' => 2750, 'capacity' => 3, 'is_extra' => 0],
    ['room_type' => 'EXTRA_BED', 'room_price' => 500, 'capacity' => 1, 'is_extra' => 1],
]);

// Create 'customers' table
Capsule::schema()->create('customers', function (Blueprint $table) {
    $table->increments('id')->primary();
    $table->string('name');
    $table->string('email');
    $table->string('phone');
    $table->integer('age');
    $table->string('address')->nullable();
    $table->timestamps();
});

// Create 'guests' table
Capsule::schema()->create('guests', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('customer_id');
    $table->string('name');
    $table->integer('age');
    $table->timestamps();

    $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
});

// Create 'bookings' table
Capsule::schema()->create('bookings', function (Blueprint $table) {
    $table->increments('id')->primary();
    $table->unsignedInteger('customer_id');
    $table->string('total_guests')->nullable();
    $table->string('total_rooms')->nullable();
    $table->string('total_days')->nullable();
    $table->string('total_price');
    $table->timestamps();

    $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
});

// Create 'booking_details' table
Capsule::schema()->create('booking_details', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('booking_id');
    $table->unsignedInteger('room_id');
    $table->string('room_number');
    $table->string('room_type');
    $table->string('room_price');
    $table->string('check_in');
    $table->string('check_out');
    $table->timestamps();

    $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
    $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
});

// Create 'booking_guest' table
Capsule::schema()->create('booking_guest', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('booking_detail_id');
    $table->unsignedInteger('guest_id');
    $table->timestamps();

    $table->foreign('booking_detail_id')->references('id')->on('booking_details')->onDelete('cascade');
    $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');
});