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
                                    <h4 class="card-title mb-2">Data Akademik</h4>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Data Mahasiswa RPL Valid Keuangan T.A
                                        <?= $ta_akademik; ?></h4>
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
                                            <table class="table table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Prodi Pilihan</th>
                                                        <th>No Peserta</th>
                                                        <th>Nama</th>
                                                        <th>No Hp</th>
                                                        <th>Identitas</th>
                                                        <th>Ijazah</th>
                                                        <th>Transkrip</th>

                                                    </tr>
                                                </thead>
                                                <tbody id='bodytable'>
                                                    <?php
                                                    // print_r($dataPesertaAsessor);
                                                    if ($dataPesertaValid) {
                                                        $i = 0;
                                                        foreach ($dataPesertaValid as $row) {
                                                            $i++;
                                                            echo "<tr>
                                                                    <td>$i</td>
                                                                    <td >$row->nama_prodi</td>
                                                                    <td for='noregis'>$row->no_peserta</td>
                                                                    <td>$row->nama</td>
                                                                    <td>$row->nohape</td>
                                                                    <td>
                                                                    <a class='btn btn-warning btn-sm' target='_blank' href='" . base_url() . "/uploads/berkas/$row->no_peserta/" . "ii" . trim($row->no_peserta) . ".pdf" . "'>Identitas</a>
                                                                    </td>
                                                                    <td><a class='btn btn-warning btn-sm' target='_blank' href='" . base_url() . "/uploads/berkas/$row->no_peserta/" . "i" . trim($row->no_peserta) . ".pdf" . "'>Ijazah</a></td>
                                                                    <td><a class='btn btn-sm btn-primary' href='" . base_url() . "/form-nilai-mahasiswa/" . $row->no_peserta . "' target='_blank'>Singkronkan</a></td>
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
        location.href = '<?= base_url('home-akademik-2/') ?>/' + taakademik;
    }
    $('document').ready(function() {

        $(".table").DataTable({
            dom: 'Bfrtip',
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
                {
                    extend: 'excelHtml5',
                    title: "DATA MAHASISWA RPL"
                },
                {
                    extend: 'pdfHtml5',
                    title: "DATA MAHASISWA RPL"
                },
                {
                    extend: 'print',
                    title: "DATA MAHASISWA RPL"
                }
            ]
        })
    })
    </script>
</body>

</html>