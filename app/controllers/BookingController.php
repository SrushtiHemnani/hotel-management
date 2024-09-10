<?php


namespace App\controllers;


use App\models\BookingDetail;
use App\models\BookingGuest;
use DateTime;
use App\models\Room;
use App\models\Guest;
use App\models\Booking;
use App\models\Customer;
use App\services\BookingService;
use http\Client\Request;
use function Symfony\Component\Clock\now;


/**
 *
 */
class BookingController extends BaseController
{
    /**
     * @return void
     */
    // File: app/controllers/BookingController.php


    public function index()
    {
        $bookings = Booking::with(['customer', 'bookingDetails.room', 'bookingDetails.bookingGuests.guest'])->get();
        $this->view('booking/index', ["bookings" => $bookings]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$check_in_date, $check_out_date, $nights] = $this->handleDates($_POST['daterange']);
            $guestData = $this->mapGuestNameAndAge($_POST);
            $bookingService = new BookingService();
            $result = $bookingService->calculateRooms($guestData);

            // Create or update customer
            $customerData = $this->getCustomerData($_POST);
            $customer = $this->createOrUpdateCustomer($customerData);

            // Find the parent booking
            $roomAllocations = $result['ROOM_ALLOCATION'];

            $booking = Booking::create([
                'customer_id' => $customer->id,
                'total_guests' => count($guestData),
                'total_rooms' => count($roomAllocations),
                'total_days' => $nights,
                'total_price' => $bookingService->calculateCost($nights),
            ]);

            foreach ($roomAllocations as $roomAllocation) {
                $this->createBookingDetail($booking, $roomAllocation, $check_in_date, $check_out_date);
            }
        }

        $this->view('booking/create');
    }
public function edit($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        [$check_in_date, $check_out_date, $nights] = $this->handleDates($_POST['daterange']);
        $guestData = $this->mapGuestNameAndAge($_POST);
        $bookingService = new BookingService();
        $result = $bookingService->calculateRooms($guestData);

        // Retrieve the existing booking
        $booking = Booking::with(['bookingDetails.bookingGuests'])->find($id);

        if (!$booking) {
            // Handle booking not found
            return;
        }

        // Update customer data
        $customerData = $this->getCustomerData($_POST);
        $customer = $this->createOrUpdateCustomer($customerData);
        $booking->customer_id = $customer->id;

        // Update booking data
        $booking->total_guests = count($guestData);
        $booking->total_rooms = count($result['ROOM_ALLOCATION']);
        $booking->total_days = $nights;
        $booking->total_price = $bookingService->calculateCost($nights);
        $booking->save();

        // Delete existing booking details and guests
        $booking->bookingDetails()->delete();

        // Create new booking details and guests
        foreach ($result['ROOM_ALLOCATION'] as $roomAllocation) {
            $this->createBookingDetail($booking, $roomAllocation, $check_in_date, $check_out_date);
        }
    }

    $this->view('booking/edit', ['booking' => $booking]);
}
    private function createBookingDetail($booking, $roomAllocation, $check_in_date, $check_out_date)
    {
        $room = Room::where('room_type', $roomAllocation['type'])->first();
        $bookingDetail = $booking->bookingDetail()->create([
            'room_id' => $room->id,
            'room_number' => $this->generateRoomNumber(),
            'room_type' => $room->room_type,
            'room_price' => $room->room_price,
            'check_in' => $check_in_date,
            'check_out' => $check_out_date,
        ]);

        $this->createBookingGuest($bookingDetail, $roomAllocation['guests']);

        if (isset($roomAllocation['extra'])) {
            $extraBed = Room::where('room_type', 'EXTRA_BED')->first();
            $bookingDetail = $booking->bookingDetail()->create([
                'room_id' => $extraBed->id,
                'room_number' => $this->generateRoomNumber(),
                'room_type' => $extraBed->room_type,
                'room_price' => $extraBed->room_price,
                'check_in' => $check_in_date,
                'check_out' => $check_out_date,
            ]);

            $this->createBookingGuest($bookingDetail, [$roomAllocation['extra']]);
        }
    }

    public function createBookingGuest(BookingDetail $bookingDetail, array $guestData)
    {

        foreach ($guestData as $guest) {

            $guest = Guest::updateOrCreate(
                [
                    'name' => $guest['name'],
                    'age' => $guest['age'],
                    'customer_id' => $bookingDetail->booking->customer->id,
                ],
                [
                    'name' => $guest['name'],
                    'age' => $guest['age'],
                    'customer_id' => $bookingDetail->booking->customer->id,
                ]
            );

            $bookingDetail->bookingGuest()->create([
                'guest_id' => $guest->id,
                'booking_detail_id' => $bookingDetail->id,
            ]);
        }
    }

    private function getCustomerData($postData)
    {
        return [
            'name' => $postData['name'],
            'age' => $postData['age'],
            'email' => $postData['email'],
            'phone' => $postData['phone'],
            'address' => $postData['address'] ?? "",
        ];
    }

    private function createOrUpdateCustomer($customerData)
    {
        return Customer::updateOrCreate(
            [
                'email' => $customerData['email'],
                'phone' => $customerData['phone'],
            ],
            $customerData
        );
    }

    private function handleDates($daterange)
    {
        if (isset($daterange)) {
            $dates = explode(' - ', $daterange);
            $check_in_date = $dates[0];
            $check_out_date = $dates[1];
        } else {
            $check_in_date = now();
            $check_out_date = now();
        }
        $check_in = DateTime::createFromFormat('m/d/Y', $check_in_date);
        $check_out = DateTime::createFromFormat('m/d/Y', $check_out_date);
        $interval = $check_in->diff($check_out);
        $nights = $interval->days;
        return [$check_in_date, $check_out_date, $nights];
    }

    private function mapGuestNameAndAge(array $guestData)
    {
        $bookingData = [
            [
                'name' => $guestData['name'],
                'age' => $guestData['age'],
            ],
        ];
        foreach ($guestData['guest_name'] as $index => $guestName) {
            $bookingData[] = [
                'name' => $guestName,
                'age' => $guestData['guest_age'][$index],
            ];
        }
        return $bookingData;
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
                echo json_encode(['errors' => $errors]);
                return;
            }
            [$check_in_date, $check_out_date, $nights] = $this->handleDates($_POST['daterange']);
            $guestData = $this->mapGuestNameAndAge($_POST);
            $bookingService = new BookingService();
            $result = $bookingService->calculateRooms($guestData);


            $cost = $bookingService->calculateCost($nights);

            // Return the result as a JSON response
            header('Content-Type: application/json');
            echo json_encode([
                'rooms' => $result,
                'cost' => $cost,
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
    }public function update($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        [$check_in_date, $check_out_date, $nights] = $this->handleDates($_POST['daterange']);
        $guestData = $this->mapGuestNameAndAge($_POST);
        $bookingService = new BookingService();
        $result = $bookingService->calculateRooms($guestData);

        // Retrieve the existing booking
        $booking = Booking::with(['bookingDetails.bookingGuests'])->find($id);

        if (!$booking) {
            // Handle booking not found
            return;
        }

        // Update customer data
        $customerData = $this->getCustomerData($_POST);
        $customer = $this->createOrUpdateCustomer($customerData);
        $booking->customer_id = $customer->id;

        // Update booking data
        $booking->total_guests = count($guestData);
        $booking->total_rooms = count($result['ROOM_ALLOCATION']);
        $booking->total_days = $nights;
        $booking->total_price = $bookingService->calculateCost($nights);
        $booking->save();

        // Delete existing booking details and guests
        $booking->bookingDetails()->delete();

        // Create new booking details and guests
        foreach ($result['ROOM_ALLOCATION'] as $roomAllocation) {
            $this->createBookingDetail($booking, $roomAllocation, $check_in_date, $check_out_date);
        }

        header('Location: /booking');
    } else {
        // Display the form for editing if GET request
        $booking = Booking::with(['customer', 'associatedBookings', 'room', 'guests', 'associatedBookings.guests', 'associatedBookings.room'])
            ->where('id', $id)
            ->firstOrFail();

        $this->view('booking/edit', ["booking" => $booking]);
    }
}

    public function delete($id)
    {
        $booking = Booking::with(['bookingGuest', 'parent', 'children'])->where('id', $id)->first();  // Find the booking
        if ($booking) {
            $booking->delete();  // This will also delete related guests and children bookings due to cascading delete
        }                          // Delete the booking
        header('Location: /booking');
    }
}
