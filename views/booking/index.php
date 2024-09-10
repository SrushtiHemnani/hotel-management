<?php include('partial/header.php'); ?>
<style>
    .details-container {
        padding: 15px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .details-container h4 {
        margin-top: 0;
        color: #333;
    }

    .details-table {
        margin-bottom: 15px;
        border-collapse: collapse;
        width: 100%;
    }

    .details-table th,
    .details-table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .details-table th {
        background-color: #f2f2f2;
    }

    .details-table td ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .action a {
        text-decoration: none;
        color: inherit;
    }
</style>
<link rel="stylesheet" type="text/css" href="assets/css/vendors/datatables.css">
<link rel="stylesheet" type="text/css" href="assets/css/vendors/datatable-extension.css">
<link rel="stylesheet" type="text/css" href="assets/css/custom.css"> <!-- Custom CSS -->
<?php //include('partial/loader.php'); ?>

<!-- Page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <?php include('partial/topbar.php'); ?>
    <!-- Page Header Ends -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?php include('partial/sidebar.php'); ?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <?php include('partial/breadcrumb.php'); ?>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <!-- Add rows Starts-->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header pb-0 card-no-border">
                                <h3>Bookings Overview</h3>
                            </div>
                            <div class="card-body">
                                <div class="dt-ext table-responsive">
                                    <table id="bookingTable" class="display datatables" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th></th> <!-- For details-control icon -->
                                            <th>Customer Name</th>
                                            <th>Total Cost</th>
                                            <th>Total Persons</th>
                                            <th>Total Rooms</th>
                                            <th>Total Days</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                              <tr class="parent-row">
                                                <td class="details-control"></td>
                                                <td><?php echo htmlspecialchars($data['customer']['name']); ?></td>
                                                <td><?php echo htmlspecialchars($data['total_price']); ?></td>
                                                <td><?php echo htmlspecialchars($data['total_guests']); ?></td>
                                                <td><?php echo htmlspecialchars($data['total_rooms']); ?></td>
                                                <td><?php echo htmlspecialchars($data['total_days']); ?></td>
                                                <td>
                                                    <ul class="action">
                                                        <li class="edit">
                                                            <a href="booking-edit/<?php echo $data['id']; ?>"><i class="icon-pencil-alt"></i></a>
                                                        </li>
                                                        <li class="delete">
                                                            <a href="booking-delete/<?php echo $data['id']; ?>"><i class="icon-trash"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>

        <?php include('partial/footer.php'); ?>
    </div>
</div>

<?php include('partial/scripts.php'); ?>

<script src="assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="assets/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
<script src="assets/js/datatable/datatable-extension/jszip.min.js"></script>
<script src="assets/js/datatable/datatable-extension/buttons.colVis.min.js"></script>
<script src="assets/js/datatable/datatable-extension/pdfmake.min.js"></script>
<script src="assets/js/datatable/datatable-extension/vfs_fonts.js"></script>
<script src="assets/js/datatable/datatable-extension/dataTables.autoFill.min.js"></script>
<script src="assets/js/datatable/datatable-extension/dataTables.select.min.js"></script>
<script src="assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js"></script>
<script src="assets/js/datatable/datatable-extension/buttons.html5.min.js"></script>
<script src="assets/js/datatable/datatable-extension/buttons.print.min.js"></script>
<script src="assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/datatable/datatable-extension/dataTables.responsive.min.js"></script>
<script src="assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js"></script>
<script src="assets/js/datatable/datatable-extension/dataTables.keyTable.min.js"></script>
<script src="assets/js/datatable/datatable-extension/dataTables.colReorder.min.js"></script>
<script src="assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js"></script>
<script src="assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js"></script>
<script src="assets/js/datatable/datatable-extension/dataTables.scroller.min.js"></script>
<script src="assets/js/datatable/datatable-extension/custom.js"></script>
<script src="assets/js/tooltip-init.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#bookingTable').DataTable({
            "data": <?php echo json_encode($bookings); ?>,
            "columns": [
                { "data": null, "defaultContent": "", "className": "details-control" },
                { "data": "customer.name" },
                { "data": "total_price" },
                { "data": "total_guests" },
                { "data": "total_rooms" },
                { "data": "total_days" },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<ul class="action">' +
                            '<li class="edit"><a href="booking-edit/' + row.id + '"><i class="icon-pencil-alt"></i></a></li>' +
                            '<li class="delete"><a href="booking-delete/' + row.id + '"><i class="icon-trash"></i></a></li>' +
                            '</ul>';
                    }
                }
            ]
        });

        // Add event listener for opening and closing details
        $('#bookingTable tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });

        function format(data) {
            let guestDetailsHtml = '';

            // Guest Allocation
            if (data.booking_details && data.booking_details.length > 0) {
                guestDetailsHtml = '<div class="details-container">' +
                    '<h4>Guest Allocation</h4>' +
                    '<table cellpadding="5" cellspacing="0" border="0" class="details-table" style="width:100%;">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Guest Name</th>' +
                    '<th>Room Number</th>' +
                    '<th>Room Type</th>' +
                    '<th>Check-In</th>' +
                    '<th>Check-Out</th>' +
                    '</tr>' +
                    '</thead><tbody>';
                data.booking_details.forEach(detail => {
                    detail.booking_guests.forEach(guest => {
                        guestDetailsHtml += '<tr>' +
                            `<td>${guest.guest.name}</td>` +
                            `<td>${detail.room_number}</td>` +
                            `<td>${detail.room_type}</td>` +
                            `<td>${detail.check_in}</td>` +
                            `<td>${detail.check_out}</td>` +
                            '</tr>';
                    });
                });
                guestDetailsHtml += '</tbody></table></div>';
            } else {
                guestDetailsHtml = '<div class="details-container"><h4>Guest Allocation</h4>No guests available.</div>';
            }

            return guestDetailsHtml;
        }
    });
</script>
<?php include('partial/footer.php'); ?>