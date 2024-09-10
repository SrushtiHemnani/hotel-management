<?php
include('partial/header.php'); ?>

<link rel="stylesheet" type="text/css" href="<?= BASE_PATH ?>assets/css/vendors/daterange-picker.css">
<link rel="stylesheet" type="text/css" href="<?= BASE_PATH ?>assets/css/vendors/sweetalert2.css">

<?php
//include('partial/loader.php'); ?>

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
                                        <h5>Edit Booking</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="bookingForm" class="theme-form mega-form" method="post" action="<?= BASE_PATH ?>booking-update/<?= $booking->id ?? '' ?>">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Personal Details</h6>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Full Name</label>
                                                        <input class="form-control" type="text" id="fullName" name="name" value="<?= htmlspecialchars($booking->customer->name ?? '', ENT_QUOTES); ?>" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Email</label>
                                                        <input class="form-control" type="email" id="email" name="email" value="<?= htmlspecialchars($booking->customer->email ?? '', ENT_QUOTES); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Phone Number</label>
                                                        <input class="form-control" type="text" id="phoneNumber" name="phone" value="<?= htmlspecialchars($booking->customer->phone ?? '', ENT_QUOTES); ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Customer Age</label>
                                                        <input class="form-control" type="number" id="customerAge" name="age" value="<?= htmlspecialchars($booking->customer->age ?? '', ENT_QUOTES); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Booking Details</h6>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Check-in and Check-out</label>
                                                        <input class="form-control" type="text" name="daterange" value="<?= htmlspecialchars(($booking->check_in ?? '') . ' - ' . ($booking->check_out ?? ''), ENT_QUOTES); ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Number of Nights</label>
                                                        <input class="form-control" type="number" id="nights" name="nights" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Total Cost</label>
                                                        <input class="form-control" type="text" id="totalCost" name="total_cost" value="<?= htmlspecialchars($booking->total_price ?? '', ENT_QUOTES); ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <h6>Guests</h6>
                                            <div id="guests">
                                                <?php
                                                if (isset($booking->customer) && isset($booking->associatedBookings)) {
                                                    $customerName = $booking->customer->name ?? '';
                                                    $customerAge = $booking->customer->age ?? '';
                                                    $allGuests = collect($booking->guests ?? [])
                                                        ->concat(collect($booking->associatedBookings ?? [])->pluck('guests')->flatten(1))
                                                        ->reject(function ($guest) use ($customerName, $customerAge) {
                                                            return $guest->name === $customerName && $guest->age == $customerAge;
                                                        });

                                                    foreach ($allGuests as $index => $guest) : ?>
                                                        <div class="guest card mb-3 p-3">
                                                            <h4>Guest <?= $index + 1; ?></h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Guest Full Name</label>
                                                                    <input class="form-control" type="text" name="guest_name[]" value="<?= htmlspecialchars($guest->name ?? '', ENT_QUOTES); ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Guest Age</label>
                                                                    <input class="form-control" type="number" name="guest_age[]" value="<?= htmlspecialchars($guest->age ?? '', ENT_QUOTES); ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="text-start mt-2">
                                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeGuest(this)">Remove</button>
                                                            </div>
                                                        </div>
                                                    <?php endforeach;
                                                } ?>
                                            </div>
                                            <button type="button" class="btn btn-secondary mb-3" onclick="addGuest()">Add Guest</button>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-primary" id="calculateCost">Calculate Cost</button>
                                                <button type="submit" class="btn btn-success">Update Booking</button>
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

            <?php
            include('partial/footer.php'); ?>
        </div>
    </div>

    <?php
    include('partial/scripts.php'); ?>
    <script src="<?= BASE_PATH ?>assets/js/tooltip-init.js"></script>
    <?php
    include('partial/footer-end.php'); ?>

    <script src="<?= BASE_PATH ?>assets/js/datepicker/daterange-picker/moment.min.js"></script>
    <script src="<?= BASE_PATH ?>assets/js/datepicker/daterange-picker/daterangepicker.js"></script>
    <script src="<?= BASE_PATH ?>assets/js/sweet-alert/sweetalert.min.js"></script>
    <script src="<?= BASE_PATH ?>assets/js/sweet-alert/app.js"></script>

    <script>
        let guestCounter = <?= isset($allGuests) ? count($allGuests) : 0; ?>;

        function addGuest() {
            guestCounter++;
            const guestDiv = document.createElement('div');
            guestDiv.classList.add('guest', 'card', 'mb-3', 'p-3');
            guestDiv.innerHTML = `
                <h4>Guest ${guestCounter}</h4>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Guest Full Name</label>
                        <input class="form-control" type="text" name="guest_name[]" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Guest Age</label>
                        <input class="form-control" type="number" name="guest_age[]" required>
                    </div>
                </div>
                <div class="text-start mt-2">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeGuest(this)">Remove</button>
                </div>
            `;
            document.getElementById('guests').appendChild(guestDiv);
            calculateCost(); // Calculate cost when a guest is added
        }

        function removeGuest(button) {
            const guestDiv = button.closest('.guest');
            guestDiv.remove();
            calculateCost(); // Calculate cost when a guest is removed
        }

        function calculateNights() {
            const dateRange = document.getElementsByName('daterange')[0].value.split(' - ');
            const checkInDate = moment(dateRange[0], 'MM/DD/YYYY');
            const checkOutDate = moment(dateRange[1], 'MM/DD/YYYY');

            if (checkInDate.isValid() && checkOutDate.isValid()) {
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
                url: '<?= BASE_PATH ?>booking-calculate-cost-estimate-and-allocation',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#totalCost').val(data.total_cost);
                    } else {
                        alert('Error calculating cost.');
                    }
                },
                error: function() {
                    alert('Error calculating cost.');
                }
            });
        }

        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end) {
                $('input[name="daterange"]').val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
                calculateNights(); // Recalculate nights on date change
            });

            $('#calculateCost').click(function() {
                calculateCost();
            });
        });
    </script>
</div>
</body>

</html>
