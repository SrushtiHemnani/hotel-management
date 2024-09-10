<?php

require __DIR__ . '/../../bootstrap/bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Disable foreign key checks for the seeding process
Capsule::statement('SET FOREIGN_KEY_CHECKS=0;');

// Truncate existing tables in reverse order of dependencies
Capsule::table('extra_reservations')->truncate();
Capsule::table('reservations')->truncate();
Capsule::table('booking_details')->truncate();
Capsule::table('bookings')->truncate();
Capsule::table('room_pricing')->truncate();
Capsule::table('room_facilities')->truncate();
Capsule::table('rooms')->truncate();
Capsule::table('floors')->truncate();
Capsule::table('buildings')->truncate();
Capsule::table('room_categories')->truncate();
Capsule::table('extra_pricing')->truncate();
Capsule::table('extras')->truncate();
Capsule::table('hotels')->truncate();
Capsule::table('identifications')->truncate();
Capsule::table('activity_log')->truncate();
Capsule::table('roles')->truncate();
Capsule::table('persons')->truncate();

// Re-enable foreign key checks
Capsule::statement('SET FOREIGN_KEY_CHECKS=1;');

function now()
{
    return date('Y-m-d H:i:s');
}

// Insert persons
Capsule::table('persons')->insertOrIgnore([
    ['name' => 'John Doe', 'email' => 'john.doe@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '123-456-7890', 'date_of_birth' => '1990-01-15', 'address' => '123 Elm Street', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '987-654-3210', 'date_of_birth' => '1985-05-22', 'address' => '456 Oak Avenue', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Michael Johnson', 'email' => 'michael.johnson@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '555-123-4567', 'date_of_birth' => '1988-07-10', 'address' => '789 Pine Road', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Emily Davis', 'email' => 'emily.davis@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '555-234-5678', 'date_of_birth' => '1992-08-30', 'address' => '321 Maple Drive', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'William Brown', 'email' => 'william.brown@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '555-345-6789', 'date_of_birth' => '1980-12-05', 'address' => '654 Cedar Street', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Olivia Wilson', 'email' => 'olivia.wilson@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '555-456-7890', 'date_of_birth' => '1995-03-20', 'address' => '987 Birch Avenue', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'James Taylor', 'email' => 'james.taylor@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '555-567-8901', 'date_of_birth' => '1993-06-15', 'address' => '123 Walnut Street', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Sophia Martinez', 'email' => 'sophia.martinez@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '555-678-9012', 'date_of_birth' => '1987-11-10', 'address' => '456 Chestnut Lane', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Daniel Anderson', 'email' => 'daniel.anderson@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '555-789-0123', 'date_of_birth' => '1991-04-25', 'address' => '789 Elmwood Circle', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Isabella Thomas', 'email' => 'isabella.thomas@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '555-890-1234', 'date_of_birth' => '1996-09-05', 'address' => '321 Fir Road', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Ethan Jackson', 'email' => 'ethan.jackson@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '555-901-2345', 'date_of_birth' => '1989-02-14', 'address' => '654 Spruce Avenue', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Ava White', 'email' => 'ava.white@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '555-012-3456', 'date_of_birth' => '1994-07-20', 'address' => '987 Willow Street', 'created_at' => now(), 'updated_at' => now()],
]);

// Insert roles
Capsule::table('roles')->insertOrIgnore([
    ['person_id' => 1, 'role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
    ['person_id' => 2, 'role' => 'user', 'created_at' => now(), 'updated_at' => now()],
    ['person_id' => 3, 'role' => 'user', 'created_at' => now(), 'updated_at' => now()],
    ['person_id' => 4, 'role' => 'user', 'created_at' => now(), 'updated_at' => now()],
    ['person_id' => 5, 'role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
    ['person_id' => 6, 'role' => 'user', 'created_at' => now(), 'updated_at' => now()],
]);

// Insert hotels
Capsule::table('hotels')->insertOrIgnore([
    ['name' => 'Grand Plaza', 'star_rating' => 5.0, 'number_of_floor' => 10, 'location' => 'Downtown', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Oceanview Resort', 'star_rating' => 4.0, 'number_of_floor' => 8, 'location' => 'Beachfront', 'created_at' => now(), 'updated_at' => now()],
]);

// Insert buildings
Capsule::table('buildings')->insertOrIgnore([
    ['hotel_id' => 1, 'name' => 'Main Building', 'created_at' => now(), 'updated_at' => now()],
    ['hotel_id' => 2, 'name' => 'Seaside Building', 'created_at' => now(), 'updated_at' => now()],
]);

// Insert floors
Capsule::table('floors')->insertOrIgnore([
    ['building_id' => 1, 'hotel_id' => 1, 'floor_number' => 1, 'created_at' => now(), 'updated_at' => now()],
    ['building_id' => 1, 'hotel_id' => 1, 'floor_number' => 2, 'created_at' => now(), 'updated_at' => now()],
    ['building_id' => 2, 'hotel_id' => 2, 'floor_number' => 1, 'created_at' => now(), 'updated_at' => now()],
    ['building_id' => 2, 'hotel_id' => 2, 'floor_number' => 2, 'created_at' => now(), 'updated_at' => now()],
]);

Capsule::table('room_categories')->insertOrIgnore([
    ['name' => 'Single Room', 'capacity' => 1, 'description' => 'A room with a single bed', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Double Room', 'capacity' => 2, 'description' => 'A room with a double bed', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Triple Room', 'capacity' => 3, 'description' => 'A triple with multiple beds and a living area', 'created_at' => now(), 'updated_at' => now()],
]);


//build rooms data

// Insert rooms
Capsule::table('rooms')->insertOrIgnore([
    ['floor_id' => 1,'hotel_id'=> 1, 'room_category_id' => 1, 'room_number' => '101', 'created_at' => now(), 'updated_at' => now()],
    ['floor_id' => 1,'hotel_id'=> 1, 'room_category_id' => 2, 'room_number' => '102', 'created_at' => now(), 'updated_at' => now()],
    ['floor_id' => 2,'hotel_id'=> 1, 'room_category_id' => 3, 'room_number' => '201', 'created_at' => now(), 'updated_at' => now()],
    ['floor_id' => 2,'hotel_id'=> 1, 'room_category_id' => 1, 'room_number' => '202', 'created_at' => now(), 'updated_at' => now()],
    ['floor_id' => 3,'hotel_id'=> 1, 'room_category_id' => 2, 'room_number' => '301', 'created_at' => now(), 'updated_at' => now()],
]);

// Insert room facilities
Capsule::table('facilities')->insertOrIgnore([
    [ 'facility' => 'Wi-Fi', 'created_at' => now(), 'updated_at' => now()],
    [ 'facility' => 'Air Conditioning', 'created_at' => now(), 'updated_at' => now()],
    [ 'facility' => 'Wi-Fi', 'created_at' => now(), 'updated_at' => now()],
    [ 'facility' => 'Wi-Fi', 'created_at' => now(), 'updated_at' => now()],
    [ 'facility' => 'TV', 'created_at' => now(), 'updated_at' => now()],
]);

Capsule::table('room_facilities')->insertOrIgnore([
    ['room_id' => 1, 'facility_id' => 1, 'created_at' => now(), 'updated_at' => now()],
    ['room_id' => 1, 'facility_id' => 2, 'created_at' => now(), 'updated_at' => now()],
    ['room_id' => 2, 'facility_id' => 1, 'created_at' => now(), 'updated_at' => now()],
    ['room_id' => 3, 'facility_id' => 1, 'created_at' => now(), 'updated_at' => now()],
    ['room_id' => 4, 'facility_id' => 5, 'created_at' => now(), 'updated_at' => now()],
]);


// Insert extras
Capsule::table('extras')->insertOrIgnore([
    ['name' => 'Extra Bed', 'description' => 'Extra bed for under 13 year child', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Breakfast', 'description' => 'Continental breakfast', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Airport Shuttle', 'description' => 'Transport to and from the airport', 'created_at' => now(), 'updated_at' => now()],
]);

// Insert extra pricing
Capsule::table('extra_pricing')->insertOrIgnore([
    ['extra_id' => 1, 'price' => 500.00, 'created_at' => now(), 'updated_at' => now()],
    ['extra_id' => 2, 'price' => 10.00, 'created_at' => now(), 'updated_at' => now()],
    ['extra_id' => 3, 'price' => 25.00, 'created_at' => now(), 'updated_at' => now()],
]);

// Insert room pricing
Capsule::table('room_pricing')->insertOrIgnore([
    ['room_id' => 1, 'price' => 1500.00, 'created_at' => now(), 'updated_at' => now()],
    ['room_id' => 2, 'price' => 2000.00, 'created_at' => now(), 'updated_at' => now()],
    ['room_id' => 3, 'price' => 2750.00, 'created_at' => now(), 'updated_at' => now()],
]);
