<?php
include('partial/header.php'); ?>

<link rel="stylesheet" type="text/css" href="assets/css/vendors/daterange-picker.css">
<link rel="stylesheet" type="text/css" href="assets/css/vendors/sweetalert2.css">

<?php
include('partial/loader.php'); ?>

<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <?php
    include('partial/topbar.php'); ?>
    <!-- Page Header Ends -->

    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?php
        include('partial/sidebar.php'); ?>
        <!-- Page Sidebar Ends-->

        <div class="page-body">
            <?php
            include('partial/breadcrumb.php'); ?>
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
                                        <form id="bookingForm" class="theme-form mega-form" method="post" action="booking-create">
                                            <h6>Personal Details</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="col-form-label">Full Name</label>
                                                    <input class="form-control" type="text" id="fullName" name="name" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="col-form-label">Email</label>
                                                    <input class="form-control" type="email" id="email" name="email" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="col-form-label">Phone Number</label>
                                                    <input class="form-control" type="text" id="phoneNumber" name="phone">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="col-form-label">Customer Age</label>
                                                    <input class="form-control" type="number" id="customerAge" name="age" required>
                                                </div>
                                            </div>

                                            <h6>Booking Details</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="col-form-label">Check-in and Check-out</label>
                                                    <input class="form-control" type="text" name="daterange" value="01/15/2017 - 02/15/2017">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="col-form-label">Number of Nights</label>
                                                    <input class="form-control" type="number" id="nights" name="nights" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="col-form-label">Total Cost</label>
                                                    <input class="form-control" type="text" id="totalCost" name="total_cost" readonly>
                                                </div>
                                            </div>

                                            <input type="hidden" id="singleRooms" name="single_rooms">
                                            <input type="hidden" id="doubleRooms" name="double_rooms">
                                            <input type="hidden" id="tripleRooms" name="triple_rooms">
                                            <input type="hidden" id="extraBeds" name="extra_beds">

                                            <h6>Guests</h6>
                                            <div id="guests">
                                                <div class="guest card mb-3 p-3">
                                                    <h4>Guest 1</h4>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Guest Full Name</label>
                                                            <input class="form-control" type="text" name="guest_name[]" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Guest Age</label>
                                                            <input class="form-control" type="number" name="guest_age[]" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="text-start mt-2">
                                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeGuest(this)">Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary mb-3" onclick="addGuest()">Add Guest</button>

                                            <div class="text-end">
                                                <button type="button" class="btn btn-primary" id="calculateCost">Calculate Cost</button>
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
        include('partial/footer.php'); ?>
    </div>
</div>

<?php
include('partial/scripts.php'); ?>
<script src="assets/js/tooltip-init.js"></script>
<?php
include('partial/footer-end.php'); ?>

<script src="assets/js/datepicker/daterange-picker/moment.min.js"></script>
<script src="assets/js/datepicker/daterange-picker/daterangepicker.js"></script>
<script src="assets/js/sweet-alert/sweetalert.min.js"></script>
<script src="assets/js/sweet-alert/app.js"></script>
<script>
    let guestCounter = 1;

    function addGuest() {
        guestCounter++;
        const guestDiv = document.createElement('div');
        guestDiv.classList.add('guest', 'card', 'mb-3', 'p-3');
        guestDiv.innerHTML = `
            <h4>Guest ${guestCounter}</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Guest Full Name</label>
                    <input class="form-control" type="text" name="guest_name[]" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Guest Age</label>
                    <input class="form-control" type="number" name="guest_age[]" required>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="text-start mt-2">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeGuest(this)">Remove</button>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('guests').appendChild(guestDiv);
    }

    function removeGuest(button) {
        const guestDiv = button.closest('.guest');
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
                return daysDifference;
            } else {
                $("#nights").val(0);
                alert('Check-out date must be after the check-in date.');
            }
        } else {
            $("#nights").val(0); // Reset if dates are not fully selected
        }
    }

    function calculateCost() {
        calculateNights();
        // Gather form data
        let formData = $('#bookingForm').serialize();

        // Send a POST request to the endpoint
        $.ajax({
            url: 'booking-calculate-cost-estimate-and-allocation',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(data) {
                // Populate form fields with returned data
                $('#totalCost').val(data.cost);
                $('#singleRooms').val(data.rooms.SINGLE_ROOM);
                $('#doubleRooms').val(data.rooms.DOUBLE_ROOM);
                $('#tripleRooms').val(data.rooms.TRIPLE_ROOM);
                $('#extraBeds').val(data.rooms.EXTRA_BED);

                if (!data.cost) {
                    // Display a sweet alert with an error message
                    swal({
                        title: 'Cost Calculation',
                        text: 'Please select a valid date range.',
                        icon: 'error'
                    });
                    return;
                }

                // Display a sweet alert with the returned data
                swal({
                    title: 'Cost Calculation',
                    text: `Total Cost: ${data.cost}\nSingle Rooms: ${data.rooms.SINGLE_ROOM}\nDouble Rooms: ${data.rooms.DOUBLE_ROOM}\nTriple Rooms: ${data.rooms.TRIPLE_ROOM}\nExtra Beds: ${data.rooms.EXTRA_BED}`,
                    icon: 'info'
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
            }
        });
    }

    $(function () {
        const today = moment().format('MM/DD/YYYY');
        $('input[name="daterange"]').daterangepicker({
            autoUpdateInput: false,
            minDate: moment(), // Disallow past dates
            startDate: today, // Default start date is today
            endDate: today, // Default end date is today
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            calculateNights(); // Automatically calculate nights when date range is selected
        });

        $('input[name="daterange"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        // Set the default value to today's date
        $('input[name="daterange"]').val(today + ' - ' + today);
    });

    $(document).ready(function() {
        $('#calculateCost').click(function(event) {
            event.preventDefault();
            calculateCost();
        });

        $('#submit').click(function(event) {
            if ($('#totalCost').val() === '') {
                event.preventDefault();
                swal({
                    title: 'Submit Error',
                    text: 'Please calculate the cost before submitting.',
                    icon: 'error'
                });
            }
        });
    });
</script>
