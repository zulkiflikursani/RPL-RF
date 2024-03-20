<!doctype html>
<html lang="en">

<head>

    <?= $title_meta ?>
    <?= $this->include('partials/rpl-head-css') ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

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
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"> Anda Berhasil Melakukan Registrasi. Silahkan cek Email anda dan login.<button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button></div>';
                        }
                    }

                    // if (isset($emailstatus)) {
                    //     echo $emailstatus;
                    // }
                    ?>


                    <div class="row" id='body-print'>
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Rekapitulasi Peserta RPL Per Fakultas</h4>
                                    <!-- <div class="col-12">
                                        <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                                            data-bs-target=".tambah-asessor-modal">Tambah Pengguna</button>
                                    </div>
                                    -->

                                    <table class='table table-bordered text-center'>
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="align-middle">No</th>
                                                <th rowspan="2" class="align-middle">Fakultas</th>
                                                <th colspan="2" class="align-middle">Jumlah</th>
                                            </tr>
                                            <tr>
                                                <th>Pendaftar</th>
                                                <th>Tervalidasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // print_r($dataAsessor);
                                            if ($dataPesertaFakultas != null) {
                                                $i = 0;
                                                $jumlahdaftar = 0;
                                                $jumlahlulus = 0;

                                                foreach ($dataPesertaFakultas as $row) {
                                                    $i++;


                                                    echo "<tr >
                                                        <td >$i</td>
                                                        <td >$row->nama_fakultas</td>
                                                        <td >$row->JumlahDaftar</td>
                                                        <td >$row->JumlahLulus</td>
                                                        </tr>";
                                                    $jumlahdaftar = $jumlahdaftar + floatval($row->JumlahDaftar);
                                                    $jumlahlulus = $jumlahlulus + floatval($row->JumlahLulus);
                                                }
                                                echo "<tr class='fw-bold'>
                                                <td colspan='2' class='align-right'> TOTAL</td>
                                                <td>$jumlahdaftar</td>
                                                <td>$jumlahlulus</td>
                                                </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Rekapitulasi Peserta RPL Per Program Studi</h4>
                                    <!-- <div class="col-12">
                                        <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                                            data-bs-target=".tambah-asessor-modal">Tambah Pengguna</button>
                                    </div>
                                    -->

                                    <table class='table table-bordered text-center'>
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="align-middle">No</th>
                                                <th rowspan="2" class="align-middle">Program Studi</th>
                                                <th rowspan="2" class="align-middle">Fakultas</th>
                                                <th colspan="3" class="align-middle">Jumlah</th>
                                            </tr>
                                            <tr>
                                                <th>Pendaftar</th>
                                                <th>Tervalidasi</th>
                                                <th>Valid Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // print_r($dataAsessor);
                                            if ($dataPesertaProdi != null) {
                                                $i = 0;
                                                $jumlahdaftar = 0;
                                                $jumlahlulus = 0;
                                                $jumlahvalidkeu = 0;

                                                foreach ($dataPesertaProdi as $row) {
                                                    $i++;


                                                    echo "<tr  >
                                                        <td >$i</td>
                                                        <td >$row->nama_prodi</td>
                                                        <td >$row->nama_fakultas</td>
                                                        <td >$row->JumlahDaftar</td>
                                                        <td >$row->JumlahLulus</td>
                                                        <td >$row->JumlahValidKeu</td>
                                                        </tr>";
                                                    $jumlahdaftar = $jumlahdaftar + floatval($row->JumlahDaftar);
                                                    $jumlahlulus = $jumlahlulus + floatval($row->JumlahLulus);
                                                    $jumlahvalidkeu = $jumlahvalidkeu + floatval($row->JumlahValidKeu);
                                                }
                                                echo "<tr class='fw-bold'>
                                                <td colspan='3' >TOTAL</td>
                                                <td>$jumlahdaftar</td>
                                                <td>$jumlahlulus</td>
                                                <td>$jumlahvalidkeu</td>
                                                </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <style type="text/css" media="print">
                                        .no-print {
                                            display: none;
                                        }

                                        table,
                                        td,
                                        th {
                                            border: 1px solid;
                                        }

                                        table {
                                            width: 100%;
                                            border-collapse: collapse;
                                        }
                                    </style>
                                    <button class="btn btn-sm btn-primary no-print" onclick="simpan_pdf()">
                                        Print</button>

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

    <script>
        function simpan_pdf() {
            var divContents = document.getElementById("body-print").innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<body > <h1>Rekapitulasi Peserta RPL <br>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
        }
    </script>
</body>

</html>