<?php

use App\controllers\UserController;
use App\controllers\AuthController;
use App\controllers\RoomController;
use App\controllers\BookingController;

return [
	'/'     => [ UserController::class, 'index' ],
	'login' => [ AuthController::class, 'login' ],
	'sign-up' => [ AuthController::class, 'signUp' ],
	'log-out' => [ AuthController::class, 'logOut' ],
	
	/**
	 * booking
	 */
	
	'booking' => [ BookingController::class, 'index' ],
	'booking-create' => [ BookingController::class, 'create' ],
	
	'booking-calculate-cost-estimate-and-allocation' => [ BookingController::class, 'calculateCostEstimateAndAllocation' ],
	'get-booking' => [ BookingController::class, 'getBooking' ],
	
	/**
	 * rooms
	 */
	'rooms' => [ RoomController::class, 'index' ],
	'room-create' => [ RoomController::class, 'create' ],
	'get-rooms' => [RoomController::class, 'getRoom' ],
	'room-edit/:id' => [RoomController::class, 'edit'],
	'room-delete/:id' => [RoomController::class, 'delete'],
];
