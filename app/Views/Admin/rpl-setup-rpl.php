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

                            <div class="modal fade update-tarif" tabindex="-1" role="dialog"
                                aria-labelledby="mytambah-modal" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" id='modal-content'>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myLargeModalLabel">Update Data Prodi
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- content -->
                                            <div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label">Kode
                                                                Prodi</label>
                                                            <input type="text" class="form-control" id="ekode_prodi"
                                                                placeholder="Masukkan Tarif RPL" value="" readonly>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label">Nama
                                                                Prodi</label>
                                                            <input type="text" class="form-control" id="enama_prodi"
                                                                placeholder="Masukkan Tarif RPL" value="" readonly>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-nama-input" class="form-label">Tarf
                                                                RPL</label>
                                                            <input type="text" class="form-control" id="tarif"
                                                                placeholder="Masukkan Tarif RPL" value="" required>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-1">
                                                            <label for="formrow-nama-input" class="form-label">Biaya Pra
                                                                Akademik</label>
                                                            <input type="text" class="form-control" id="praakademik"
                                                                placeholder="Masukkan Biaya Pra Akademik" value=""
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-email-input" class="form-label">Biaya
                                                                BPP</label>
                                                            <input type="text" class="form-control" id="bpp"
                                                                placeholder="Masukkan Biaya BPP" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-email-input" class="form-label">Biaya
                                                                SPP</label>
                                                            <input type="text" class="form-control" id="spp"
                                                                placeholder="Masukkan Biaya SPP" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="formrow-email-input" class="form-label">SKS
                                                                Maksimal</label>
                                                            <input type="text" class="form-control" id="sksmax"
                                                                placeholder="Masukkan SKS Maksimal" value="" required>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div>
                                                    <button type="button" onclick='updatetarif()'
                                                        class="btn btn-primary w-md">Simpan</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-2">Data RPL yang ditawarkan Program Studi</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered ">
                                                <thead class="align-middle text-center table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Prodi</th>
                                                        <th>Nama Prodi</th>
                                                        <th>A1</th>
                                                        <th>A2</th>
                                                        <th>A3</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='datarpl'>
                                                    <?php
                                                    if (isset($data)) {
                                                        $i = 0;
                                                        foreach ($data as $row) {
                                                            $i++;
                                                            if ($row->A1 == 1) {
                                                                $a1checked = 'checked';
                                                            } else {
                                                                $a1checked = '';
                                                            }

                                                            if ($row->A2 == 1) {
                                                                $a2checked = 'checked';
                                                            } else {
                                                                $a2checked = '';
                                                            }
                                                            if ($row->A3 == 1) {
                                                                $a3checked = 'checked';
                                                            } else {
                                                                $a3checked = '';
                                                            }
                                                            echo "<tr >
                                                                    <td>" . $i . "</td>
                                                                    <td for='kode_prodi'>" . $row->kode_prodi . "</td>
                                                                    <td for='nama_prodi'>" . $row->nama_prodi . "</td>
                                                                    <td for='a1'><input type='checkbox' $a1checked /></td>
                                                                    <td for='a2'> <input type='checkbox'  $a2checked/></td>
                                                                    <td for='a3'> <input type='checkbox' $a3checked /></td>
                                                                  
                                                                </tr>";
                                                        }
                                                    }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <button class="button btn btn-primary" onclick='update()'>Simpan</button>
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
    function update() {
        $('#loading').show()
        url = '<?= base_url('update-jenisrpl') ?>'

        var arr = [];
        $('#datarpl >tr').each(function() {
            kode_prodi = $(this).find('td[for=kode_prodi]').html()
            a1 = $(this).find('td[for=a1]').children()
            a2 = $(this).find('td[for=a2]').children()
            a3 = $(this).find('td[for=a3]').children()

            if (a1.is(':checked')) {
                arr.push({
                    kode_prodi: kode_prodi,
                    jenis_rpl: 1
                })
            }
            if (a2.is(':checked')) {
                arr.push({
                    kode_prodi: kode_prodi,
                    jenis_rpl: 2
                })
            }
            if (a3.is(':checked')) {
                arr.push({
                    kode_prodi: kode_prodi,
                    jenis_rpl: 3
                })
            }

            arrOK = JSON.stringify(arr)
        })
        $.post(url, {
            data: arrOK,
        }, function(data) {
            data = JSON.parse(data)
            if (data['status'] == 1) {

                alert(data['message'])
                $('#loading').hide()
            } else {
                alert(data['message'])
                $('#loading').hide()
            }

        })

    }

    function updatetarif() {
        $('#loading').show()
        url = '<?= base_url('updatetarif') ?>'
        kode_prodi = $('#ekode_prodi').val()
        nama_prodi = $('#enama_prodi').val()
        tarif = $('#tarif').val()
        praakademik = $('#praakademik').val()
        bpp = $('#bpp').val()
        spp = $('#spp').val()
        sksmax = $('#sksmax').val()
        $.post(url, {
            kode_prodi: kode_prodi,
            nama_prodi: nama_prodi,
            tarif: tarif,
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