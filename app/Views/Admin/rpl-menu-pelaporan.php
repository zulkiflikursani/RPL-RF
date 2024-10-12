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

                    if (isset($alert)) {
                        if ($alert != "") {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">' . $alert . '<button type="button" class="btn-close" data-bs-dismiss="alert"
        aria-label="Close"></button></div>';
                        }
                    }


                    // if (isset($status)) {
                    //     if ($status == true) {
                    //         echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Melakukan Registrasi. Silahkan cek Email anda dan login.<button type="button" class="btn-close" data-bs-dismiss="alert"
                    //     aria-label="Close"></button></div>';
                    //     }
                    // }

                    // if (isset($emailstatus)) {
                    //     echo $emailstatus;
                    // }
                    ?>


                    <div class="row">
                        <div class="col-xl-12">


                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title mb-2">Berita Acara Asessment Program A2/A3</h2>
                                    <p class=" mb-2">Program Studi</p>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id='form-simpan' class="col-lg-6">
                                                <select class="select form-select " name='kode_prodi' id='kode_prodi'>
                                                    <option value="">Pilih Prodi</option>
                                                    <?php
                                                    if (isset($dataProdi)) {
                                                        foreach ($dataProdi as $row) {
                                                            echo "<option value='$row->kode_prodi'>$row->nama_prodi</option>";
                                                        }
                                                    }

                                                    ?>
                                                </select>

                                            </div>
                                            <button class="btn btn-primary mt-3"
                                                onclick="tampilkan()">Tampilkan</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h2 class="card-title mb-2">Berita Acara Asessment Program A1</h2>
                                    <p class=" mb-2">Program Studi</p>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id='form-simpan' class="col-lg-6">
                                                <select class="select form-select " name='kode_prodi2' id='kode_prodi2'>
                                                    <option value="">Pilih Prodi</option>
                                                    <?php
                                                    if (isset($dataProdi)) {
                                                        foreach ($dataProdi as $row) {
                                                            echo "<option value='$row->kode_prodi'>$row->nama_prodi</option>";
                                                        }
                                                    }

                                                    ?>
                                                </select>

                                            </div>
                                            <button class="btn btn-primary mt-3"
                                                onclick="tampilkan2()">Tampilkan</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h2 class="card-title mb-2">Berita Acara Pleno</h2>
                                    <p class="mb-2">Program Studi</p>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id='form-simpan' class="col-lg-6">
                                                <select class="select form-select " name='fakultas' id='fakultas'>
                                                    <option value="">Pilih Fakultas</option>
                                                    <?php
                                                    if (isset($dataFakultas)) {
                                                        foreach ($dataFakultas as $row) {
                                                            echo "<option value='$row->kode_fakultas'>$row->nama_fakultas</option>";
                                                        }
                                                    }

                                                    ?>
                                                </select>

                                            </div>
                                            <button class="btn btn-primary mt-3"
                                                onclick="tampilkan3()">Tampilkan</button>
                                        </div>
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
    <script src="<?= base_url() ?>/assets/libs/jszip/jszip.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

    <!-- Responsive examples -->
    <script src="<?= base_url() ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- apexcharts -->
    <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script>
        function tampilkan() {
            kode_prodi = $('#kode_prodi').val()
            if (kode_prodi == '') {
                alert("Silahkan Mengisi Program Studi terlebih dahulu !")

            } else {
                url = '<?= base_url('baasessmentProdi') ?>' + "/" + kode_prodi;
                var location = window.open(url, '_blank')
                location.focus();
            }
        }

        function tampilkan2() {
            kode_prodi = $('#kode_prodi2').val()
            if (kode_prodi == '') {
                alert("Silahkan Mengisi Program Studi terlebih dahulu !")

            } else {
                url = '<?= base_url('baasessmentA1Prodi') ?>' + "/" + kode_prodi;
                var location = window.open(url, '_blank')
                location.focus();
            }
        }

        function tampilkan3() {
            kode_fakultas = $('#fakultas').val()
            ta_akademik = '<?php echo $ta_akademik; ?>'
            if (kode_prodi == '') {
                alert("Silahkan Mengisi Program Studi terlebih dahulu !")

            } else {
                url = '<?= base_url('data-mhs-per-fak') ?>' + "/" + kode_fakultas;
                var location = window.open(url, '_blank')
                location.focus();
            }
        }
    </script>
</body>

</html>