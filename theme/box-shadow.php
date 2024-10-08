<?php include('partial/header.php');?>

<?php include('partial/loader.php');?>

<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <?php include('partial/topbar.php');?>
    <!-- Page Header Ends -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?php include('partial/sidebar.php');?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <?php include('partial/breadcrumb.php'); ?>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card box-shadow-title">
                            <div class="card-header">
                                <h5>Examples</h5><span>While shadows on components are disabled by default in Bootstrap
                                    and can be enabled via <code>$enable-shadows</code>, you can also quickly add or
                                    remove a shadow with our <code>box-shadow</code> utility classes. Includes support
                                    for <code>.shadow-none</code> and three default sizes (which have associated
                                    variables to match).</span>
                            </div>
                            <div class="card-body row">
                                <div class="col-12">
                                    <h6 class="sub-title mt-0">Larger shadow</h6>
                                </div>
                                <div class="col-sm-4">
                                    <div class="shadow-lg p-25 shadow-showcase text-center">
                                        <h5 class="m-0 f-18">Larger shadow</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="shadow-lg p-25 shadow-showcase text-center">
                                        <h5 class="m-0 f-18">Larger shadow</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="shadow-lg p-25 shadow-showcase text-center">
                                        <h5 class="m-0 f-18">Larger shadow</h5>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="sub-title">Regular shadow</h6>
                                </div>
                                <div class="col-sm-4">
                                    <div class="shadow shadow-showcase p-25 text-center">
                                        <h5 class="m-0 f-18">Regular shadow</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="shadow shadow-showcase p-25 text-center">
                                        <h5 class="m-0 f-18">Regular shadow</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="shadow shadow-showcase p-25 text-center">
                                        <h5 class="m-0 f-18">Regular shadow</h5>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="sub-title">Small shadow</h6>
                                </div>
                                <div class="col-sm-4">
                                    <div class="shadow-sm shadow-showcase p-25 text-center">
                                        <h5 class="m-0 f-18">Small shadow</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="shadow-sm shadow-showcase p-25 text-center">
                                        <h5 class="m-0 f-18">Small shadow</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="shadow-sm shadow-showcase p-25 text-center">
                                        <h5 class="m-0 f-18">Small shadow</h5>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="sub-title">No shadow</h6>
                                </div>
                                <div class="col-sm-4">
                                    <div class="shadow-none shadow-showcase p-25 text-center">
                                        <h5 class="m-0 f-18">No shadow</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="shadow-none shadow-showcase p-25 text-center">
                                        <h5 class="m-0 f-18">No shadow</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="shadow-sm shadow-showcase shadow-none p-25 text-center">
                                        <h5 class="m-0 f-18">No shadow</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
        
        <?php include('partial/footer.php');?>
    </div>
</div>
<?php include('partial/scripts.php'); ?>
<script src="assets/js/tooltip-init.js"></script>
<?php include('partial/footer-end.php'); ?>