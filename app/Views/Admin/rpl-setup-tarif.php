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

                    if (isset($validstatus)) {
                        if ($validstatus != "") {
                            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">' . $validstatus . '<button type="button" class="btn-close" data-bs-dismiss="alert"
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

                            <div class="modal fade update-tarif" tabindex="-1" role="dialog" aria-labelledby="mytambah-modal" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" id='modal-content'>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">Update Data Prodi
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- content -->
                                            <div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label">Kode
                                                                Prodi</label>
                                                            <input type="text" class="form-control" id="ekode_prodi" placeholder="Masukkan Tarif RPL" value="" readonly>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label">Nama
                                                                Prodi</label>
                                                            <input type="text" class="form-control" id="enama_prodi" placeholder="Masukkan Tarif RPL" value="" readonly>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label">Tarf
                                                                RPL</label>
                                                            <input type="text" class="form-control" id="tarif" placeholder="Masukkan Tarif RPL" value="" required>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label">Tarf
                                                                RPL (DODI)</label>
                                                            <input type="text" class="form-control" id="tarifdodi" placeholder="Masukkan Tarif RPL (DODI)" value="" required>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-1">
                                                            <label for="formrow-nama-input" class="form-label">Biaya Pra
                                                                Akademik</label>
                                                            <input type="text" class="form-control" id="praakademik" placeholder="Masukkan Biaya Pra Akademik" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-email-input" class="form-label">Biaya
                                                                BPP</label>
                                                            <input type="text" class="form-control" id="bpp" placeholder="Masukkan Biaya BPP" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-email-input" class="form-label">Biaya
                                                                SPP</label>
                                                            <input type="text" class="form-control" id="spp" placeholder="Masukkan Biaya SPP" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-email-input" class="form-label">SKS
                                                                Maksimal</label>
                                                            <input type="text" class="form-control" id="sksmax" placeholder="Masukkan SKS Maksimal" value="" required>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div>
                                                    <button type="button" onclick='updatetarif()' class="btn btn-primary w-md">Simpan</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-2">Data Tarif RPL Per Prodi</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered ">
                                                <thead class="align-middle text-center table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Prodi</th>
                                                        <th>Nama Prodi</th>
                                                        <th>Tarif RPL</th>
                                                        <th>Tarif RPL (DODI)</th>
                                                        <th>Pra Akademik</th>
                                                        <th>BPP</th>
                                                        <th>SPP</th>
                                                        <th>Sks Maksimal Rekognisi</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($tarif)) {
                                                        $i = 0;
                                                        foreach ($tarif as $row) {
                                                            $i++;
                                                            echo "<tr>
                                                                    <td>" . $i . "</td>
                                                                    <td for='kode_prodi'>" . $row['kode_prodi'] . "</td>
                                                                    <td for='nama_prodi'>" . $row['nama_prodi'] . "</td>
                                                                    <td for='tarif'>" . $row['tarif'] . "</td>
                                                                    <td for='tarifdodi'>" . $row['tarif_dodi'] . "</td>
                                                                    <td for='praakademik'>" . $row['prakademik'] . "</td>
                                                                    <td for='bpp'>" . $row['bpp'] . "</td>
                                                                    <td for='spp'>" . $row['spp'] . "</td>
                                                                    <td for='sks_max' width='10px'>" . $row['sks_max_rekognisi'] . "</td>
                                                                    <td for='aksi'><button class='btn btn-sm btn-primary' onclick='edit($(this))'>Edit</button></td>
                                                                </tr>";
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
                                    <!-- <h4 class="card-title mb-4">Data Status Klaim Mahasiswa</h4>
                                    <div class="row">
                                        <div class="col-lg-12">

                                        </div>
                                    </div>   -->
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
        function edit(ini) {
            kode_prodi = ini.parent().parent().find('td[for=kode_prodi]').html()
            nama_prodi = ini.parent().parent().find('td[for=nama_prodi]').html()
            tarif = ini.parent().parent().find('td[for=tarif]').html()
            tarifdodi = ini.parent().parent().find('td[for=tarifdodi]').html()
            praakademik = ini.parent().parent().find('td[for=praakademik]').html()
            bpp = ini.parent().parent().find('td[for=bpp]').html()
            spp = ini.parent().parent().find('td[for=spp]').html()
            sks_max = ini.parent().parent().find('td[for=sks_max]').html()
            // $('#id_prodi').val()

            $('#ekode_prodi').val(kode_prodi);
            $('#enama_prodi').val(nama_prodi);
            $('#tarif').val(tarif);
            $('#tarifdodi').val(tarifdodi);
            $('#praakademik').val(praakademik);
            $('#bpp').val(bpp);
            $('#spp').val(spp);
            $('#sksmax').val(sks_max);
            // alert(kode_prodi)
            $('.update-tarif').modal('show');
        }

        function updatetarif() {
            $('#loading').show()
            url = '<?= base_url('updatetarif') ?>'
            kode_prodi = $('#ekode_prodi').val()
            nama_prodi = $('#enama_prodi').val()
            tarif = $('#tarif').val()
            tarifdodi = $('#tarifdodi').val()
            praakademik = $('#praakademik').val()
            bpp = $('#bpp').val()
            spp = $('#spp').val()
            sksmax = $('#sksmax').val()
            $.post(url, {
                kode_prodi: kode_prodi,
                nama_prodi: nama_prodi,
                tarif: tarif,
                tarif_dodi: tarifdodi,
                praakademik: praakademik,
                bpp: bpp,
                spp: spp,
                sksmax: sksmax,
            }, function(data) {
                console.log(data);
                if (data === 'true') {
                    $('#loading').hide()
                    $('.update-tarif').modal('hide')
                    let confirmAction = confirm("DATA BERHASIL DIUPDATE");
                    if (confirmAction) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                }
            })
        }
    </script>
</body>

</html>