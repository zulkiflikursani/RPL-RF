<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>
    <link href="<?= base_url() ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

</head>

<body data-topbar="dark" data-layout="horizontal">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?= $this->include("partials/rpl-horizontal-afterregis-pengguna") ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <?= $page_title ?>

                    <?php

                    if (isset($dataerror)) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        foreach ($dataerror as $error) {

                            echo $error . "</br>";
                        };
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button></div>';
                    }

                    if (isset($status)) {
                        if ($status != '') {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">' . $status . '<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }

                    // if (isset($emailstatus)) {
                    //     echo $emailstatus;
                    // }
                    ?>


                    <div class="row">
                        <div class="col-xl-12">


                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Data Mahasiswa Sudah Divalidasi Prodi</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No Registrasi</th>
                                                        <th>Nama Mahasiswa</th>
                                                        <th>Program Studi</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='bodytable'>
                                                    <?php
                                                    // print_r($dataPesertaAsessor);
                                                    if ($dataPesertaSudahValidProdi) {
                                                        $i = 0;
                                                        foreach ($dataPesertaSudahValidProdi as $row) {
                                                            $i++;
                                                            if ($row->jenis_rpl == 1) {
                                                                $url = base_url("tanggapanasessora1/$row->no_peserta");
                                                            } else {
                                                                $url = base_url("tanggapanasessor/$row->no_peserta");
                                                            }
                                                            echo "<tr>
                                                                    <td>$i</td>
                                                                    <td>$row->no_peserta</td>
                                                                    <td>$row->nama</td>
                                                                    <td>$row->nama_prodi</td>
                                                                    <td><a href='$url'><button class='btn btn-sm btn-primary'>Detail</button></a></td>
                                                                </tr>";
                                                            // echo $row->nama;
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end row -->






            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->



        <?= $this->include('partials/rpl-footer') ?>
    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <?= $this->include('partials/vendor-scripts') ?>
    <!-- data-table -->
    <script src="<?= base_url() ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <!--<script src="<?= base_url() ?>/assets/libs/jszip/jszip.min.js"></script>-->
    <!--<script src="<?= base_url() ?>/assets/libs/pdfmake/build/pdfmake.min.js"></script>-->
    <!--<script src="<?= base_url() ?>/assets/libs/pdfmake/build/vfs_fonts.js"></script>-->
    <!--<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>-->
    <!--<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>-->
    <!--<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>-->

    <!-- Responsive examples -->
    <script src="<?= base_url() ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- apexcharts -->
    <!--<script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>-->

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script>
        $('document').ready(function() {

            $(".table").DataTable()
        })
    </script>
</body>

</html>