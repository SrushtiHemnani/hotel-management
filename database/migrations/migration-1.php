<?php

require __DIR__ . '/../../bootstrap/bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

// Drop existing tables in reverse order of dependencies
Capsule::schema()->dropIfExists('extra_reservations');
Capsule::schema()->dropIfExists('reservations');
Capsule::schema()->dropIfExists('payments');
Capsule::schema()->dropIfExists('billing');

Capsule::schema()->dropIfExists('booking_details');
Capsule::schema()->dropIfExists('bookings');
Capsule::schema()->dropIfExists('room_pricing');
Capsule::schema()->dropIfExists('room_facilities');
Capsule::schema()->dropIfExists('facilities');
Capsule::schema()->dropIfExists('rooms');
Capsule::schema()->dropIfExists('floors');
Capsule::schema()->dropIfExists('buildings');
Capsule::schema()->dropIfExists('room_categories');
Capsule::schema()->dropIfExists('extra_pricing');
Capsule::schema()->dropIfExists('extras');
Capsule::schema()->dropIfExists('roles');
Capsule::schema()->dropIfExists('hotels');
Capsule::schema()->dropIfExists('identifications');
Capsule::schema()->dropIfExists('activity_log');
Capsule::schema()->dropIfExists('persons');

// Create 'persons' table
Capsule::schema()->create('persons', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->string('email')->unique()->nullable(); // Not all guests may have an email
    $table->string('password')->nullable();
    $table->string('phone')->nullable();
    $table->date('date_of_birth')->nullable();
    $table->string('address')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

// Create 'hotels' table
Capsule::schema()->create('hotels', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->double('star_rating', 2, 1);  // 1.0, 2.0, 3.0, etc.

    $table->string('location');
    $table->timestamps();
    $table->softDeletes();
});

// Create 'roles' table
Capsule::schema()->create('roles', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('person_id');
    $table->unsignedInteger('hotel_id')->nullable();
    $table->enum('role', ['admin', 'user']);
    $table->timestamps();
    $table->unique(['person_id', 'role', 'hotel_id']);

    $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
    $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('set null');
});

// Create 'buildings' table
Capsule::schema()->create('buildings', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('hotel_id');
    $table->string('name')->nullable();
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
});

// Create 'floors' table
Capsule::schema()->create('floors', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('building_id')->nullable(); // Link to building
    $table->unsignedInteger('hotel_id');
    $table->integer('floor_number'); // e.g., 1, 2, 3 for floor levels
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('building_id')->references('id')->on('buildings')->onDelete('set null');
    $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
    $table->unique(['hotel_id', 'building_id', 'floor_number']);
});

// Create 'room_categories' table
Capsule::schema()->create('room_categories', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name'); // Single bed, double bed, etc.
    $table->integer('capacity'); // 1, 2, 3, etc.
    $table->string('description')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

// Create 'rooms' table
Capsule::schema()->create('rooms', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('hotel_id');
    $table->unsignedInteger('floor_id');
    $table->unsignedInteger('room_category_id');
    $table->string('room_number');
    $table->boolean('is_available')->default(true);
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
    $table->foreign('floor_id')->references('id')->on('floors')->onDelete('cascade');
    $table->foreign('room_category_id')->references('id')->on('room_categories')->onDelete('cascade');

    $table->unique(['hotel_id', 'floor_id', 'room_number']);
});

// Create 'facilities' table
Capsule::schema()->create('facilities', function (Blueprint $table) {
    $table->increments('id');
    $table->string('facility'); // Wi-Fi, AC, TV, etc.
    $table->timestamps();
    $table->softDeletes();
});

// Create 'room_facilities' table
Capsule::schema()->create('room_facilities', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('room_id');
    $table->unsignedInteger('facility_id');
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
    $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
});

// Create 'room_pricing' table
Capsule::schema()->create('room_pricing', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('room_id');
    $table->double('price');
    $table->date('start_date')->nullable();
    $table->date('end_date')->nullable();
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
    $table->unique(['room_id', 'start_date']);
});

// Create 'extras' table
Capsule::schema()->create('extras', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->string('description')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

// Create 'extra_pricing' table
Capsule::schema()->create('extra_pricing', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('extra_id');
    $table->double('price');
    $table->date('start_date')->nullable();
    $table->date('end_date')->nullable();
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade');
    $table->unique(['extra_id', 'start_date']);
});

// Create 'bookings' table
Capsule::schema()->create('bookings', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('person_id');
    $table->unsignedInteger('hotel_id');
    $table->date('check_in');
    $table->date('check_out');
    $table->enum('status', ['confirmed', 'checked_in', 'checked_out', 'cancelled']);
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
    $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
});

// Create 'booking_details' table
Capsule::schema()->create('booking_details', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('booking_id');
    $table->unsignedInteger('room_id');
    $table->unsignedInteger('room_pricing_id');
    $table->string('room_number');
    $table->string('room_type');

    $table->date('check_in');
    $table->date('check_out');
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
    $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
    $table->foreign('room_pricing_id')->references('id')->on('room_pricing')->onDelete('cascade');
});
Capsule::schema()->create('billing', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('booking_id');
    $table->double('total_amount');
    $table->double('tax_amount')->nullable();
    $table->double('discount_amount')->nullable();
    $table->double('final_amount');
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
});
// Create 'payments' table
Capsule::schema()->create('payments', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('booking_id');
    $table->unsignedInteger('billing_id');
    $table->double('amount');
    $table->enum('status', ['paid', 'partial_payment', 'unpaid', 'refund_initiated', 'payment_failed', 'disputed'])->default('unpaid');
    $table->enum('method', ['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'cash','upi']);
    $table->string('transaction_id')->unique()->nullable();  // Unique transaction identifier from the payment gateway
    $table->timestamp('paid_at')->nullable();  // Timestamp of payment completion
    $table->json('metadata')->nullable();  // Store additional information such as payment gateway response
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
    $table->foreign('billing_id')->references('id')->on('billing')->onDelete('cascade');
});

// Create 'extra_reservations' table
Capsule::schema()->create('extra_reservations', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('booking_detail_id');
    $table->unsignedInteger('extra_pricing_id');

    $table->unsignedInteger('extra_id');
    $table->integer('quantity');
    $table->timestamps();
    $table->softDeletes();
    $table->foreign('extra_pricing_id')->references('id')->on('extra_pricing')->onDelete('cascade');

    $table->foreign('booking_detail_id')->references('id')->on('booking_details')->onDelete('cascade');
    $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade');
});

// Create 'reservations' table
Capsule::schema()->create('reservations', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('booking_detail_id');
    $table->unsignedInteger('person_id');
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('booking_detail_id')->references('id')->on('booking_details')->onDelete('cascade');
    $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
});

// Create 'activity_log' table
Capsule::schema()->create('activity_log', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('person_id')->nullable();  // User who performed the action
    $table->string('event');  // Type of event (e.g., 'created', 'updated', 'deleted')
    $table->string('subject_type');  // Type of the model (e.g., 'Hotel', 'Room') table being acted upon
    $table->unsignedInteger('subject_id');  // ID of the model being acted upon
    $table->json('properties')->nullable();  // Extra properties related to the event
    $table->timestamps();

    $table->foreign('person_id')->references('id')->on('persons')->onDelete('set null');
    $table->index(['subject_type', 'subject_id']);  // Index for faster querying
});

// Create 'identifications' table
Capsule::schema()->create('identifications', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('person_id');
    $table->string('identification_type');
    $table->string('identification_number')->unique();
    $table->string('file_path')->nullable();
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
});