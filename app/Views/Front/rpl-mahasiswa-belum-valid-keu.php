<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>

</head>

<body data-topbar="dark" data-layout="horizontal">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?= $this->include("partials/rpl-horizontal") ?>

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
                        if ($status == true) {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Memperbaharui data.<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }

                    if (isset($datasubmit)) {

                        if (isset($datasubmit["jenis_rpl"])) {
                            $biodata = $datasubmit;
                        } else {

                            $biodata = $datasubmit[0];
                        }
                    }

                    ?>


                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h2 class="mb-4 text-center">Informasi RPL</h2>
                                    <div class="row">
                                        <div class='col-md-12'>
                                            <div class="row">
                                                <div class="mb-3 col-2">
                                                    <h3 for="formrow-nama-input" class="form-label">No Registrasi
                                                    </h3>
                                                    <h3 class=''>
                                                        Nama
                                                    </h3>
                                                    <h3 class=''>
                                                        Program Studi
                                                    </h3>
                                                </div>
                                                <div class="mb-3 col-8">
                                                    <h3 for="formrow-nama-input" class="form-label">:
                                                        <?= (isset($biodata["no_peserta"]) ? $biodata["no_peserta"] : '') ?>
                                                    </h3>
                                                    <h3 class=''>:
                                                        <?= (isset($biodata["nama"]) ? $biodata["nama"] : '') ?>
                                                    </h3>
                                                    <h3 class=''>:
                                                        <?= (isset($prodi) ? $prodi : '') ?>
                                                    </h3>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <h3 class='text-center mb-4'>Silahkan Kirim Bukti Pembayaran Ke bagaian
                                                    Keuangan untuk
                                                    mendapatkan validasi atas pembayaran Program Rekognisi Pembelajaran
                                                    Lampau Universitas Fajar</h3>

                                                <h3 class='text-center mb-5'>Nomor Konfirmasi WA : 08123456789156</h3>
                                                <h3 class='text-center mb-2'>Bagian Keuangan Universitas Fajar</h3>

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

    <!-- apexcharts -->
    <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>
</body>

</html>