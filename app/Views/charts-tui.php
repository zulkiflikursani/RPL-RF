<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>

    <!-- tui charts Css -->
    <link href="assets/libs/tui-chart/tui-chart.min.css" rel="stylesheet" type="text/css" />

    <?= $this->include('partials/head-css') ?>

</head>

<?= $this->include('partials/body') ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?= $this->include('partials/menu') ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <?= $page_title ?>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Bar chart</h4>

                                <div id="bar-charts" dir="ltr"></div>

                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Column chart</h4>

                                <div id="column-charts" dir="ltr"></div>

                            </div>
                        </div>
                    </div> <!-- end col -->

                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Line chart</h4>

                                <div id="line-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Area chart</h4>

                                <div id="area-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Bubble chart</h4>

                                <div id="bubble-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Scatter chart</h4>

                                <div id="scatter-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Pie chart</h4>

                                <div id="pie-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Donut pie chart</h4>

                                <div id="donut-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row">

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Heatmap chart</h4>

                                <div id="heatmap-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Treemap chart</h4>

                                <div id="treemap-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Map chart</h4>

                                <div id="map-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Boxplot chart</h4>

                                <div id="boxplot-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Bullet chart</h4>

                                <div id="bullet-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Radial chart</h4>

                                <div id="radial-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


        <?= $this->include('partials/footer') ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<?= $this->include('partials/right-sidebar') ?>

<?= $this->include('partials/vendor-scripts') ?>

<!-- tui charts plugins -->
<script src="assets/libs/tui-chart/tui-chart-all.min.js"></script>

<!-- tui charts map -->
<script src="assets/libs/tui-chart/maps/usa.js"></script>

<!-- tui charts plugins -->
<script src="assets/js/pages/tui-charts.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>