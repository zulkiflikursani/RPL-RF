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
                                    <h4 class="card-title mb-2">Tahun Akademik</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <form id='form-simpan' action="<?= base_url('udpate-taakademik') ?>"
                                                method="POST" class="col-lg-6">
                                                <select class="select form-select " name='ta_akademik' id='ta_akademik'>
                                                    <?php
                                                    $tamin = floatval(substr($ta_akademik, 0, 4)) - 5;
                                                    $tamax = floatval(substr($ta_akademik, 0, 4)) + 5;

                                                    for ($x = $tamin; $x <= $tamax; $x++) {
                                                        if ($x . "1" == $ta_akademik) {
                                                            $selected1 = 'selected';
                                                            $selected2 = '';
                                                        } else  
                                                    if ($x . "2" == $ta_akademik) {

                                                            $selected1 = '';
                                                            $selected2 = 'selected';
                                                        } else {
                                                            $selected1 = '';
                                                            $selected2 = '';
                                                        }
                                                        echo "<option value='" . $x . "1' $selected1>" . $x . "1</option>";
                                                        echo "<option value='" . $x . "2' $selected2>" . $x . "2</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </form>
                                            <button class="btn btn-primary mt-3"
                                                onclick="simpantaakademik()">Simpan</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h4 class="card-title mb-2">Batas Pembayaran Tagihan RPL</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class=" col-lg-6">
                                                <input type="date" class="form-control" name="tgl_batas_bayar"
                                                    id="tgl_batas_bayar" value="<?= $batasbayar ?>">
                                            </div>
                                            <button class="btn btn-primary mt-3"
                                                onclick="simpanbatasbayar()">Simpan</button>
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
    function simpantaakademik() {
        $('#form-simpan').submit()
    }

    function simpanbatasbayar() {
        batasbayar = $('#tgl_batas_bayar').val();
        if (batasbayar == '') {
            alert("Silahkan mengisi tanggal batas pembayaran")
        } else {
            url = '<?= base_url('udpate-batas-bayar') ?>'
            $.post(url, {
                tgl_batas_bayar: batasbayar
            }, function(data) {
                alert(data)
            })
        }

    }
    </script>
</body>

</html>