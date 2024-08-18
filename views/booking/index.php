<?php
include( 'partial/header.php' ); ?>
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/datatable-extension.css">
<?php
include( 'partial/loader.php' ); ?>


    <!-- page-wrapper Start-->
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
                        <!-- Add rows  Starts-->
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header pb-0 card-no-border">
                                    <h3>Booking</h3>
                                </div>
                                <div class="card-body">
                                    <div class="dt-ext table-responsive">
                                        <table class="display" id="export-button">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer Name</th>
                                                <th>Room Price</th>
                                                <th>Total Price</th>
                                                <th>Check-In</th>
                                                <th>Check-Out</th>
                                                <th>Rooms</th>
                                                <th>Guests</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($booking as $b) { ?>
                                                <tr>
                                                    <td><?php echo $b['id']; ?></td>
                                                    <td><?php echo $b['customer']['name']; ?></td>
                                                    <td><?php echo $b['room_price']; ?></td>
                                                    <td><?php echo $b['total_price']; ?></td>
                                                    <td><?php echo $b['check_in']; ?></td>
                                                    <td><?php echo $b['check_out']; ?></td>
                                                    <td><?php echo $b['rooms']['room_type']; ?></td>

                                                    <td>
                                                        <!-- Guest List Dropdown -->
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton<?php echo htmlspecialchars($b['id']); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                View Guests
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo htmlspecialchars($b['id']); ?>">
                                                                <?php if (isset($b['customer']['guests']) && is_array($b['customer']['guests'])): ?>
                                                                    <?php foreach ($b['customer']['guests'] as $guest): ?>
                                                                        <a class="dropdown-item" href="#">
                                                                            <?php echo htmlspecialchars($guest['name']); ?> - <?php echo htmlspecialchars($guest['age']); ?>
                                                                        </a>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <span class="dropdown-item">No guests available</span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <ul class="action">
                                                            <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a></li>
                                                            <li class="delete"><a href="#"><i class="icon-trash"></i></a></li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer Name</th>
                                                <th>Room Price</th>
                                                <th>Total Price</th>
                                                <th>Check-In</th>
                                                <th>Check-Out</th>
                                                <th>Rooms</th>
                                                <th>Guests</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
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
    <script src="assets/js/tooltip-init.js"></script>><
<?php
include( 'partial/footer-end.php' ); 