<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>
    <!-- DataTables -->
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
                        // print_r($dataerror);
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        foreach ($dataerror as $error) {

                            echo $error . "</br>";
                        };
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button></div>';
                    }

                    if (isset($status)) {
                        if ($status == true) {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Melakukan Pembatalan Validasi.<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        } else if ($status == false) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> Anda Gagal Melakukan Pembatalan Validasi. Karena Asessor Sudah Memberikan Penilaian<button type="button" class="btn-close" data-bs-dismiss="alert"
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
                                    <h4 class="card-title mb-4">Data Mahasiswa</h4>
                                    <div class="col-12">

                                    </div>
                                    <!-- modal tambah asessor -->


                                    <table id='datamhs' class='table table-bordered'>
                                        <thead>
                                            <tr>
                                                <th class="col-1">No</th>
                                                <th class="col-3">No Registrasi</th>
                                                <th class="col-3">Nama</th>
                                                <th class="col-3">Program Studi</th>
                                                <th class="col-1">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // print_r($dataAsessor);
                                            if ($dataMhs != null) {
                                                $i = 0;
                                                foreach ($dataMhs as $row) {
                                                    $i++;
                                                    echo "<tr >
                                                        <td >$i</td>
                                                        <td for='noregi'>" . $row->no_peserta . "</td>
                                                        <td for='nama'>" . $row->nama . "</td>
                                                        <td for='nama'>" . $row->nama_prodi . "</td>
                                                        <td>
                                                        <button class='button btn-primary btn-sm' noregis='$row->no_peserta' onClick='notifbatalklaim($(this))' >Batal Klaim</button>
                                                        </td>
                                                    </tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="modal fade batalklaim-modal" tabindex="-1" role="dialog"
                                        aria-labelledby="mytambah-modal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class=" modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Perhatian !</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="<?= base_url("batalklaimmhs") ?>">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="formrow-nama-input"
                                                                        class="form-label">Yakin
                                                                        akan Membatalkan Klaim Mahasiswa<span
                                                                            id='email'></span>
                                                                        ?</label>
                                                                    <input type="hidden" class="form-control"
                                                                        id="noregis" name="noregis"
                                                                        placeholder="Masukkan Nama" value="" required
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type=" submit" class="btn btn-primary w-md">
                                                                Ya</button> <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
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
    <!-- Required datatable js -->
    <script src="<?= base_url() ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- apexcharts -->
    <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- dashboard init -->
    <script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>

    <!-- Datatable init js -->
    <script src="<?= base_url() ?>assets/js/pages/datatables.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script>
    $('document').ready(function() {
        $('#datamhs').DataTable()
    })

    function notifbatalklaim(ini) {
        a = ini.attr('noregis')
        $('#noregis').val(a);
        $('.batalklaim-modal').modal('show')

    }

    
    </script>
</body>

</html>