<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>
    <link href="<?= base_url() ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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
                        if ($status == true) {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Melakukan Registrasi. Silahkan cek Email anda dan login.<button type="button" class="btn-close" data-bs-dismiss="alert"
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
                                    <h4 class="card-title mb-2">Data Mahasiswa</h4>
                                </div>
                            </div>
                            <div class="card">
                                <div class="modal fade batal-bayar-modal" tabindex="-1" role="dialog" aria-labelledby="mytambah-modal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class=" modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myLargeModalLabel">Perhatian !</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-12">
                                                                <label for="formrow-nama-input" class="form-label">Yakin
                                                                    akan membatalkan validasi pembayaran</label>
                                                                ?</label>
                                                                <input type="hidden" class="form-control" id="confnoregis" name="norgis" placeholder="" value="" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button onclick="unvalidbayar()" class="btn btn-primary w-md">
                                                            Ya</button> <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Data Mahasiswa RPL</h4>
                                    <div class="row">
                                        <div class="row col-lg-12">
                                            <div class="col-lg-2">
                                                <label for="" class="">Tahun Akademik</label>
                                            </div>
                                            <?php
                                            $tahunnow = date('Y');
                                            $tahunmulai = 2022;

                                            $option = '';
                                            for ($x = $tahunmulai; $x <= $tahunnow; $x++) {
                                                $selected = '';
                                                $gentaakademik  = $x . "1";
                                                if ($ta_akademik == $gentaakademik) {
                                                    $selected = 'selected';
                                                }
                                                $option .=  "<option value='$gentaakademik' $selected >$gentaakademik
                                                </option>";
                                                $gentaakademik  = $x . "2";
                                                $selected = '';

                                                if ($ta_akademik == $gentaakademik) {
                                                    $selected = 'selected';
                                                }
                                                $option .=  "<option value='$gentaakademik' $selected >$gentaakademik
                                                </option>";
                                            }


                                            ?>
                                            <div class="col-lg-3">
                                                <select name="" id="takademik" class="col-lg-3 mb-3 form-select">
                                                    <?= $option ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <button class="btn btn-primary" onclick="tampilkan()">Tampilkan
                                                </button>
                                            </div>

                                        </div>
                                        <div class="col-lg-12">
                                            <table class="table table1 table-bordered" title='DATA MAHASISWA LULUS RPL'>
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No Peserta</th>
                                                        <th>Nama</th>
                                                        <th>Program Studi</th>
                                                        <th>No Hp</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='bodytable'>
                                                    <?php
                                                    // print_r($dataStatusMahasiswa);
                                                    if ($dataStatusMahasiswa) {
                                                        $i = 0;
                                                        foreach ($dataStatusMahasiswa as $row) {
                                                            $i++;
                                                            echo "<tr>
                                                                    <td>$i</td>
                                                                    <td for='noregis'>$row->no_peserta</td>
                                                                    <td>$row->nama</td>
                                                                    <td>$row->nama_prodi</td>
                                                                    <td>$row->nohape</td>              
                                                                    <td>$row->status_valid</td>              

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
            taakademik = $('#takademik').val();
            location.href = '<?= base_url('data-status-mhs/') ?>/' + taakademik;
        }
        $('document').ready(function() {

            judul1 = $('.table1').attr('title')
            judul2 = $('.table2').attr('title')
            judul3 = $('.table3').attr('title')

            $(".table1").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    // 'copy', 'csv', 'excel', 'pdf', 'print'
                    {
                        extend: 'excelHtml5',
                        title: judul1
                    },
                    {
                        extend: 'pdfHtml5',
                        title: judul1
                    },
                    {
                        extend: 'print',
                        title: judul1
                    }
                ]
            })
            $(".table2").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    // 'copy', 'csv', 'excel', 'pdf', 'print'
                    {
                        extend: 'excelHtml5',
                        title: judul2
                    },
                    {
                        extend: 'pdfHtml5',
                        title: judul2
                    },
                    {
                        extend: 'print',
                        title: judul2
                    }
                ]
            })
            $(".table3").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    // 'copy', 'csv', 'excel', 'pdf', 'print'
                    {
                        extend: 'excelHtml5',
                        title: judul3
                    },
                    {
                        extend: 'pdfHtml5',
                        title: judul3
                    },
                    {
                        extend: 'print',
                        title: judul3
                    }
                ]
            })

        })
    </script>
</body>

</html>