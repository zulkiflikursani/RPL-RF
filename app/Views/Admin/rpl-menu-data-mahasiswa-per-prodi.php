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


                            <!-- <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-2">Tahun Akademik Transkrip Mahasiswa</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id='form-simpan' class="col-lg-6">
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
                                            </div>
                                            <button class="btn btn-primary mt-3"
                                                onclick="tampilkan()">Tampilkan</button>
                                        </div>
                                    </div>
                                </div>

                            </div> -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-2">Data Mahasiswa RPL</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id='form-simpan' class="col-lg-6">
                                                <label for="">Tahun Akademik</label>
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

                                            </div>
                                            <?php
                                            if (session()->get('sttpengguna') == 1) {

                                            ?>
                                            <div class="col-lg-6 mt-2">
                                                <label for="Jenis Laporan">Prodi</label>
                                                <select name="" class="select form-select" name='prodi' id='prodi'>
                                                    <?php
                                                        if ($prodi) {
                                                            foreach ($prodi as $row) {

                                                                echo "<option value='$row->kode_prodi'>$row->nama_prodi</option>";
                                                            }
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                            <?php

                                            } else {

                                            ?>
                                            <div class="col-lg-6 mt-2">
                                                <label for="Jenis Laporan">Jenis Laporan</label>
                                                <select name="" class="select form-select" name='jenislaporan'
                                                    id='jenislaporan'>
                                                    <option value="1">Transkrip Nilai</option>
                                                    <option value="2">Daftar Mahasiswa RPL</option>
                                                </select>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                            <button class="btn btn-primary mt-3"
                                                onclick="setTampilkan()">Tampilkan</button>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="text-center">
                                            <h3>DAFTAR PESERTA REKOGNISI</h3>
                                            <h3>TAHUN AKADEMIK <span id='spantaakademik'></span></h3>
                                        </div>
                                        <table class="table table-striped tabel-mahasiswa">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>No Peserta</th>
                                                    <th>Nama Peserta</th>
                                                    <th>Jenis RPL</th>
                                                    <th>Konsentrasi</th>
                                                    <th>Nama Asessor</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="body-table">

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
        taakademik = $('#ta_akademik').val()


        $(".table").DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                title: 'DAFTAR PESERTA REKOGNISI TAHUN AKADEMIK ' + taakademik,

            }, {
                extend: 'print',
                title: 'DAFTAR PESERTA REKOGNISI TAHUN AKADEMIK ' + taakademik,

            }]
        })
        $('#spantaakademik').html(taakademik)
    })

    function setTampilkan() {
        <?php
            if (session()->get('sttpengguna') == 1) {
            ?>
        tampilkandataprodi()
        <?php
            } else {
            ?>
        jenislaporan = $('#jenislaporan').val();
        if (jenislaporan == 1) {
            tampilkan();
        } else if (jenislaporan == 2) {
            tampilkandataprodi();
        }
        <?php
            }
            ?>
    }

    function tampilkan() {
        taakademik = $('#ta_akademik').val()
        url = '<?= base_url('data-mhs-per-prodi') ?>' + "/" + taakademik;
        var location = window.open(url, '_blank')
        location.focus();
    }

    function tampilkandataprodi() {

        dataTable = $('.tabel-mahasiswa').DataTable()
        taakademik = $('#ta_akademik').val()

        <?php
            if (session()->get('sttpengguna') == 1) {
            ?>
        kode_prodi = $('#prodi').val()
        <?php
            } else {
            ?>
        kode_prodi = '<?= session()->get("kode_prodi") ?>'
        <?php
            }
            ?>
        url = '<?= base_url('getStatusMhsRpl') ?>'
        $.post(url, {
            ta_akademik: taakademik,
            kode_prodi: kode_prodi
        }, function(data) {
            // console.log(data);
            data = JSON.parse(data)
            let i = 0;
            dataTable.rows().remove().draw();

            $.each(data, function(a, row) {
                i++
                dataTable.row.add([
                    i,
                    row['no_peserta'],
                    row['nama'],
                    "A" + row['jenis_rpl'],
                    row['konsentrasi'],
                    row['nm_asessor'],
                    row['status_mahasiswa_rpl']


                ]).draw()


            })
        })
        $('#spantaakademik').html(taakademik)
    }
    </script>
</body>

</html>