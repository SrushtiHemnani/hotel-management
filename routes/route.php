<?php

use App\controllers\UserController;
use App\controllers\AuthController;
use App\controllers\BookingController;

return [
	'/'     => [ UserController::class, 'index' ],
	'login' => [ AuthController::class, 'login' ],
	'sign-up' => [ AuthController::class, 'signUp' ],
	'log-out' => [ AuthController::class, 'logOut' ],
	
	/**
	 * booking
	 */
	
	'booking' => [ BookingController::class, 'listBookings' ],
	'booking-create' => [ BookingController::class, 'create' ],
];
