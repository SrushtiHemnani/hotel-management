<?php

namespace App\controllers;

use DateTime;
use App\models\Room;
use App\models\Guest;
use App\models\Booking;
use App\models\Customer;
use App\services\BookingService;
use function Symfony\Component\Clock\now;

/**
 *
 */
class BookingController extends BaseController
{
	/**
	 * @return void
	 */
	public function index()
	{
		$this->view('booking/index');
	}
	
	/**
	 * @return void
	 */
	public function getBooking()
	{
		header('Content-Type: application/json');
		$request = $_GET;
		$query = Booking::with('customer', 'rooms');    // Eager load the customer and rooms
		
		$start = intval($request['start']);
		$length = intval($request['length']);
		$totalRecords = $query->count();
		$data = $query->skip($start)->take($length)->get();
		
		
		$formattedData = $data->map(function ($booking) {
			$rooms = $booking?->rooms?->room_type;
			return [
				'customer_name' => $booking->customer->name,
				'total_price'   => '&#8377;' . $booking->total_price,
				'check_in'      => $booking->check_in,
				'check_out'     => $booking->check_out,
				'guest'         => $booking->customer->guests,
				'rooms'         => $rooms,
			];
		});
		
		$response = [
			'draw'            => intval($request['draw']),
			'recordsTotal'    => $totalRecords,
			'recordsFiltered' => $totalRecords,
			'data'            => $formattedData,
		];
		
		echo json_encode($response);
	}
	
	
	/**
	 * @return void
	 * @throws \DateMalformedStringException
	 */
	public function create()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$customerData = [
				'name'    => $_POST['name'],
				'age'     => $_POST['age'],
				'email'   => $_POST['email'],
				'phone'   => $_POST['phone'],
				'address' => $_POST['address'] ?? "",
			];
			
			// Create or update customer
			$customer = Customer::updateOrCreate(
				[
					'email' => $customerData['email'],
					'phone' => $customerData['phone'],
				],
				$customerData
			);
			
			$guestData = [];
			foreach ($_POST['guest_name'] as $index => $fullName) {
				$guestData[] = [
					'name'        => $fullName,
					'customer_id' => $customer->id,
					'age'         => $_POST['guest_age'][ $index ],
				];
			}
			
			// Bulk upsert guests
			Guest::upsert($guestData, [ 'name', 'customer_id' ], [ 'age' ]);
			
			// Retrieve the POST data for booking calculation
			$age = $_POST['age'];
			$guest_age = $_POST['guest_age'];
			// Handle dates
			if (isset($_POST['daterange'])) {
				$dates = explode(' - ', $_POST['daterange']);
				$check_in_date = $dates[0];
				$check_out_date = $dates[1];
			} else {
				$check_in_date = now();
				$check_out_date = now();
			}
			
			// get from the checkin and checkout date
			$check_in = DateTime::createFromFormat('m/d/Y', $check_in_date);
			$check_out = DateTime::createFromFormat('m/d/Y', $check_out_date);
			$interval = $check_in->diff($check_out);
			$nights = $interval->days;
			
			
			// Calculate booking details
			$bookingService = new BookingService();
			[ $adults, $childrenUnder13 ] = $bookingService->calculateAdultsAndChildren([ $age, ...$guest_age ]);
			$result = $bookingService->calculateRooms($adults, $childrenUnder13);
			$cost = $bookingService->calculateCost($nights);
			
			
			// Prepare booking data for batch insertion
			$bookingData = [];
			foreach ($result as $roomType => $quantity) {
				if ($quantity > 0) {
					$room = Room::where('room_type', $roomType)->first();
					if ($room) {
						for ($i = 0; $i < $quantity; $i++) {
							$bookingData[] = [
								'room_id'     => $room->id,
								'room_number' => $this->generateRoomNumber(), // Using a method to generate room number
								'room_type'   => $roomType,
								'room_price'  => $room->room_price,
								'customer_id' => $customer->id,
								'check_in'    => $check_in_date,
								'check_out'   => $check_out_date,
								'total_price' => $cost,
								'created_at'  => now(),
							];
						}
					}
				}
			}
			
			// Bulk insert bookings
			Booking::insert($bookingData);
			
			
			// Redirect to the booking page
			header('Location: /booking');
		}
		
		$this->view('booking/create');
	}
	
	/**
	 * @return int
	 */
	private function generateRoomNumber()
	{
		// Generate room number logic, could be more complex if needed
		return rand(100, 999);
	}
	
	
	/**
	 * @return void
	 */
	public function calculateCostEstimateAndAllocation()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Validate the data
			$errors = $this->validateBookingData();
			if (!empty($errors)) {
				header('Content-Type: application/json');
				echo json_encode([ 'errors' => $errors ]);
				return;
			}
			// Retrieve the POST data
			$age = $_POST['age'];
			$nights = $_POST['nights'];
			$guest_age = $_POST['guest_age'];
			
			// Use the validated data to calculate the cost estimate and allocation
			$bookingService = new BookingService();
			[ $adults, $childrenUnder13 ] = $bookingService->calculateAdultsAndChildren([ $age, ...$guest_age ]);
			$result = $bookingService->calculateRooms($adults, $childrenUnder13);
			$cost = $bookingService->calculateCost($nights);
			
			// Return the result as a JSON response
			header('Content-Type: application/json');
			echo json_encode([
				                 'rooms' => $result,
				                 'cost'  => $cost,
			                 ]);
		}
	}
	
	/**
	 * @return array
	 */
	public function validateBookingData()
	{
		$errors = [];
		
		// Check if age is set and is a number
		if (!isset($_POST['age']) || !is_numeric($_POST['age'])) {
			$errors[] = 'Invalid age.';
		}
		
		// Check if guest_age is set and is an array
		if (!isset($_POST['guest_age']) || !is_array($_POST['guest_age'])) {
			$errors[] = 'Invalid guest age data.';
		} else {
			// Check if all guest ages are numbers
			foreach ($_POST['guest_age'] as $guest_age) {
				if (!is_numeric($guest_age)) {
					$errors[] = 'Invalid guest age data.';
					break;
				}
			}
		}
		
		return $errors;
	}
	
}