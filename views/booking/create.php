<?php
include( 'partial/header.php' ); ?>

<link rel="stylesheet" type="text/css" href="assets/css/vendors/daterange-picker.css">

<?php
include( 'partial/loader.php' ); ?>

<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
	<?php
	include( 'partial/topbar.php' ); ?>
    <!-- Page Header Ends -->

    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
		<?php
		include( 'partial/sidebar.php' ); ?>
        <!-- Page Sidebar Ends-->

        <div class="page-body">
			<?php
			include( 'partial/breadcrumb.php' ); ?>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>New Booking</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="bookingForm" class="theme-form mega-form" method="post">
                                            <h6>Personal Details</h6>
                                            <div class="mb-3">
                                                <label class="col-form-label">First Name</label>
                                                <input class="form-control" type="text" id="firstName" name="first_name"
                                                       required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Last Name</label>
                                                <input class="form-control" type="text" id="lastName" name="last_name"
                                                       required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Email</label>
                                                <input class="form-control" type="email" id="email" name="email"
                                                       required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Phone Number</label>
                                                <input class="form-control" type="text" id="phoneNumber"
                                                       name="phone_number">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Customer Age</label>
                                                <input class="form-control" type="number" id="customerAge" name="age"
                                                       required>
                                            </div>

                                            <h6>Booking Details</h6>
                                            <div class="mb-3">
                                                <label class="col-form-label">Check-in and Check-out</label>
                                                <input class="form-control" type="text" name="daterange"
                                                       value="01/15/2017 - 02/15/2017">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Number of Nights</label>
                                                <input class="form-control" type="number" id="nights" name="nights"
                                                       readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Total Cost</label>
                                                <input class="form-control" type="text" id="totalCost" name="total_cost"
                                                       readonly>
                                            </div>

                                            <input type="hidden" id="singleRooms" name="single_rooms">
                                            <input type="hidden" id="doubleRooms" name="double_rooms">
                                            <input type="hidden" id="tripleRooms" name="triple_rooms">
                                            <input type="hidden" id="extraBeds" name="extra_beds">

                                            <h6>Guests</h6>
                                            <div id="guests">
                                                <div class="guest card mb-3 p-3">
                                                    <h4>Guest 1</h4>
                                                    <div class="form-group">
                                                        <label class="form-label">Guest First Name</label>
                                                        <input class="form-control" type="text"
                                                               name="guest_first_name[]" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Guest Last Name</label>
                                                        <input class="form-control" type="text" name="guest_last_name[]"
                                                               required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Guest Age</label>
                                                        <input class="form-control" type="number" name="guest_age[]"
                                                               required>
                                                    </div>
                                                    <button type="button" class="btn btn-danger"
                                                            onclick="removeGuest(this)">Remove
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary mb-3" onclick="addGuest()">
                                                Add Guest
                                            </button>

                                            <div class="text-end">
                                                <button type="button" class="btn btn-primary" onclick="calculateCost()">
                                                    Calculate Cost
                                                </button>
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button type="button" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
		
		<?php
		include( 'partial/footer.php' ); ?>
    </div>
</div>

<?php
include( 'partial/scripts.php' ); ?>
<script src="assets/js/tooltip-init.js"></script>
<?php
include( 'partial/footer-end.php' ); ?>


<script src="assets/js/datepicker/daterange-picker/moment.min.js"></script>
<script src="assets/js/datepicker/daterange-picker/daterangepicker.js"></script>
<script>
    let guestCounter = 1;

    function addGuest() {
        guestCounter++;
        const guestDiv = document.createElement('div');
        guestDiv.classList.add('guest', 'card', 'mb-3', 'p-3');
        guestDiv.innerHTML = `
            <h4>Guest ${ guestCounter }</h4>
            <div class="form-group">
                <label class="form-label">Guest First Name</label>
                <input class="form-control" type="text" name="guest_first_name[]" required>
            </div>
            <div class="form-group">
                <label class="form-label">Guest Last Name</label>
                <input class="form-control" type="text" name="guest_last_name[]" required>
            </div>
            <div class="form-group">
                <label class="form-label">Guest Age</label>
                <input class="form-control" type="number" name="guest_age[]" required>
            </div>
            <button type="button" class="btn btn-danger" onclick="removeGuest(this)">Remove</button>
        `;
        document.getElementById('guests').appendChild(guestDiv);
    }

    function removeGuest(button) {
        const guestDiv = button.parentElement;
        guestDiv.remove();
    }

    function calculateNights() {
        const dateRange = document.getElementsByName('daterange')[0].value.split(' - ');
        const checkInDate = moment(dateRange[0], 'MM/DD/YYYY');
        const checkOutDate = moment(dateRange[1], 'MM/DD/YYYY');

        if (checkInDate && checkOutDate) {
            const daysDifference = checkOutDate.diff(checkInDate, 'days');

            if (daysDifference > 0) {
                $("#nights").val(daysDifference);
            } else {
                $("#nights").val(0);
                alert('Check-out date must be after the check-in date.');
            }
        } else {
            $("#nights").val(0); // Reset if dates are not fully selected
        }
    }
    
    function calculateCost() {
        calculateNights(); // Ensure nights are calculated first

        const customerAge = parseInt(document.getElementById('customerAge').value);
        const guestAges = Array.from(document.getElementsByName('guest_age[]')).map(input => parseInt(input.value));
        const nights = parseInt(document.getElementById('nights').value) || 0;

        const allAges = [customerAge, ...guestAges];
        const filteredAges = allAges.filter(age => age >= 5);

        const adults = filteredAges.filter(age => age >= 13);
        const childrenUnder13 = filteredAges.filter(age => age >= 5 && age < 13);

        // Debugging: Check for null values
        console.log({ allAges, adults, childrenUnder13, filteredAges });

        let singleRooms = 0, doubleRooms = 0, tripleRooms = 0;
        let rooms = [];

        // Allocate rooms for adults
        while (adults.length >= 3) {
            tripleRooms++;
            rooms.push({ type: 'triple', extraBed: false });
            adults.splice(0, 3);
        }

        while (adults.length >= 2) {
            doubleRooms++;
            rooms.push({ type: 'double', extraBed: false });
            adults.splice(0, 2);
        }

        while (adults.length >= 1) {
            singleRooms++;
            rooms.push({ type: 'single', extraBed: false });
            adults.splice(0, 1);
        }

        // Function to allocate extra beds for kids under 13
        function allocateExtraBeds(kids, rooms) {
            for (let i = 0; i < kids.length; i++) {
                let bedAllocated = false;
                for (let j = 0; j < rooms.length; j++) {
                    if (!rooms[j].extraBed) {
                        rooms[j].extraBed = true;
                        bedAllocated = true;
                        break;
                    }
                }
                if (!bedAllocated) {
                    singleRooms++;
                    rooms.push({ type: 'single', extraBed: true });
                }
            }
        }

        // Allocate extra beds for kids under 13
        allocateExtraBeds(childrenUnder13, rooms);

        // Debugging: Check room allocation
        console.log({ singleRooms, doubleRooms, tripleRooms, rooms });

        // Calculate total cost
        const roomRate = ( singleRooms * 1500 ) + ( doubleRooms * 2000 ) + ( tripleRooms * 2750 );
        const extraBedCost = rooms.filter(room => room.extraBed).length * 500;
        const totalCost = ( roomRate + extraBedCost ) * nights;

        // Debugging: Check total cost calculation
        console.log({ roomRate, extraBedCost, totalCost });

        document.getElementById('totalCost').value = totalCost.toFixed(2);

        // Populate hidden fields with room details
        document.getElementById('singleRooms').value = singleRooms;
        document.getElementById('doubleRooms').value = doubleRooms;
        document.getElementById('tripleRooms').value = tripleRooms;
        document.getElementById('extraBeds').value = rooms.filter(room => room.extraBed).length;
    }

    $(function () {
        $('input[name="daterange"]').daterangepicker({
            autoUpdateInput: false,
            minDate: moment(), // Disallow past dates
            startDate: moment(), // Default start date is today
            endDate: moment(), // Default end date is today
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="daterange"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });
</script>
