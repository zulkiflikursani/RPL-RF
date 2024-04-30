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

                    if (isset($validstatus)) {
                        if ($validstatus != "") {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">' . $validstatus . '<button type="button" class="btn-close" data-bs-dismiss="alert"
        aria-label="Close"></button></div>';
                        }
                    }



                    // if (isset($status)) {
                    //     if ($status == true) {
                    //         echo '>';
                    //     }
                    // }

                    // if (isset($emailstatus)) {
                    //     echo $emailstatus;
                    // }
                    ?>

                    <div id='notif'>
                        <!--  -->
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <!-- modal konfimasi validasi reg prodi -->
                            <div class="modal fade confirm-validasi-dodi" tabindex="-1" role="dialog"
                                aria-labelledby="mytambah-modal" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content" id='modal-content'>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">Validasi Registrasi
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- content -->
                                            <div class="">
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <div class="mb-1">
                                                            <label for="formrow-nama-input" class="form-label">No
                                                                Registrasi Mahasiswa</label>
                                                            <input type="text" class="form-control" id="confnopeserta"
                                                                placeholder="Masukkan No Peserta" value="" required
                                                                readonly>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-1">
                                                            <label for="formrow-nama-input" class="form-label">Nama
                                                                Mahasiswa</label>
                                                            <input type="text" class="form-control" id="confnama"
                                                                placeholder="Masukkan Nama Mahasiswa" value="" required
                                                                readonly>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-1">
                                                            <label for="formrow-nama-input" class="form-label">Status
                                                                Mahasiswa Dodi</label>
                                                            <select class="form-select" id='confdudi'>
                                                                <option value=''>Pilih Status Dodi</option>
                                                                <option value="1">YA</option>
                                                                <option value="0">TIDAK</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="button" onclick="validasiRegisOk()"
                                                        class="btn btn-primary w-md">Simpan</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-2">Data Prodi</h4>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Data Registrasi Mahasiswa</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No Registrasi</th>
                                                        <th>Nama Mahasiswa</th>
                                                        <th>No HP</th>
                                                        <th>Aksi</th>


                                                    </tr>
                                                </thead>
                                                <tbody id='bodytable'>
                                                    <?php
                                                    // print_r($dataregistrasiMHS);
                                                    // die;
                                                    if ($dataregistrasiMHS) {
                                                        $i = 0;
                                                        foreach ($dataregistrasiMHS as $row) {
                                                            $noregis = $row['no_peserta'];
                                                            $statusvalid = $row['validasi_regis_prodi'];
                                                            $jenisrpl = $row['jenis_rpl'];
                                                            $namapeserta = $row['nama'];
                                                            if ($row['validasi_regis_prodi'] == 0) {
                                                                $url = '';
                                                                $button = 'Validasi';
                                                                $warna = 'btn-warning';
                                                            } else {
                                                                $url = '';
                                                                $button = 'Unvalidasi';
                                                                $warna = 'btn-primary';
                                                            }
                                                            $i++;
                                                            echo "<tr>
                                                                    <td>$i</td>
                                                                    <td>" . $row['no_peserta'] . "</td>
                                                                    <td>" . $row['nama'] . "</td>
                                                                    <td>" . $row['nohape'] . "</td>
                                                                    <td><button onClick=\"confimValidasiRegistrasi('" . $noregis . "',$statusvalid,$jenisrpl,'$namapeserta')\" class='btn btn-sm $warna'>$button</button>
                                                                </td></tr>";
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
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Data Mahasiswa Belum Punya Asessor</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No Registrasi</th>
                                                        <th>Nama Mahasiswa</th>
                                                        <th>Program Studi</th>


                                                    </tr>
                                                </thead>
                                                <tbody id='bodytable'>
                                                    <?php
                                                    // print_r($dataPesertaAsessor);
                                                    if ($dataMhsbelumpunyaasessor) {
                                                        $i = 0;
                                                        foreach ($dataMhsbelumpunyaasessor as $row) {
                                                            $i++;
                                                            echo "<tr>
                                                                    <td>$i</td>
                                                                    <td>$row->no_peserta</td>
                                                                    <td>$row->nama</td>
                                                                    <td>$row->nama_prodi</td>
                                                                    
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

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Data Mahasiswa Belum Divalidasi</h4>
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
                                                    if ($dataPesertaBelumValid) {
                                                        $i = 0;
                                                        foreach ($dataPesertaBelumValid as $row) {
                                                            $i++;

                                                            if ($row->jenis_rpl == 1) {
                                                                $url = base_url("validprodia1/$row->no_peserta");
                                                            } else {
                                                                $url = base_url("validprodi/$row->no_peserta");
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
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Data Mahasiswa Sudah Divalidasi</h4>
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
                                                    if ($dataPesertaSudahValid) {
                                                        $i = 0;
                                                        foreach ($dataPesertaSudahValid as $row) {
                                                            $i++;

                                                            if ($row->jenis_rpl == 1) {
                                                                $url = base_url("validprodia1/$row->no_peserta/4");
                                                            } else {
                                                                $url = base_url("validprodi/$row->no_peserta/4");
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
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Data Mahasiswa Sudah Divalidasi Dekan</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No Registrasi</th>
                                                        <th>Nama Mahasiswa</th>
                                                        <th>Program Studi</th>
                                                        <th>No Hape</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='bodytable'>
                                                    <?php
                                                    // print_r($dataPesertaAsessor);
                                                    if ($dataPesertaSudahValidDekan) {
                                                        $i = 0;
                                                        foreach ($dataPesertaSudahValidDekan as $row) {
                                                            $i++;
                                                            if ($row->jenis_rpl == 1) {
                                                                $url = base_url("bamahasiswaa1/$row->no_peserta");
                                                            } else {
                                                                $url = base_url("bamahasiswa/$row->no_peserta");
                                                            }

                                                            echo "<tr>
                                                                    <td>$i</td>
                                                                    <td>$row->no_peserta</td>
                                                                    <td>$row->nama</td>
                                                                    <td>$row->nama_prodi</td>
                                                                    <td>$row->nohape</td>
                                                                    <td><a href='$url' target='_blank'><button class='btn btn-sm btn-primary'>Detail</button></a></td>
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
    $('document').ready(function() {

        $(".table").DataTable()
    })

    function confimValidasiRegistrasi(a, b, c, d) {
        nopeserta = a;
        namapeserta = d;
        if (c == 1) {
            if (b == 0) {
                $('#confnopeserta').val(nopeserta)
                $('#confnama').val(namapeserta)
                $('.confirm-validasi-dodi').modal('show');
            } else {
                validasiRegis(a, b, 0)
            }
        } else {
            validasiRegis(a, b, 0)
        }

    }

    function validasiRegisOk() {
        noregis = $('#confnopeserta').val();
        dudi = $('#confdudi').val();

        if (dudi == '') {
            alert('Silahkan mengisi status dudi mahasistwa !');
        } else {
            validasiRegis(noregis, 0, dudi)
        }

    }

    function validasiRegis(a, b, c) {
        sttpengguna = '<?php echo session()->get('sttpengguna') ?>'
        if (sttpengguna !== '7') {
            if (b == 0) {
                $('#notif').append(
                    '<div class="alert alert-warning alert-dismissible fade show" role="alert">Hanya bisa divalidasi oleh PIC Prodi <button type = "button" class = "btn-close"data-bs-dismiss = "alert" aria-label = "Close"></button></div > '
                )
            } else {
                $('#notif').append(
                    '<div class="alert alert-warning alert-dismissible fade show" role="alert">Hanya bisa diunvalidasi oleh PIC Prodi <button type = "button" class = "btn-close"data-bs-dismiss = "alert" aria-label = "Close"></button></div > '
                )
            }
            setTimeout(function() {
                $('#notif').children().remove()
            }, 5000);
        } else {
            $.post('/validasiregprodi', {
                a: a,
                b: b,
                c: c
            }, function(data) {
                data = JSON.parse(data);
                $('.confirm-validasi-dodi').modal('hide');
                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');
                $('#notif').append(
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">' + data[
                        'result'
                    ] +
                    '<button type="button" class="btn btn-sm btn-primary mx-4" onclick="refresh()">Refresh</button></div >'
                )
            })
        }
    }

    function refresh() {

        location.reload();
    }
    </script>
</body>

</html>