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
                                    <h4 class="card-title mb-2">Data Keuangan</h4>
                                </div>
                            </div>
                            <div class="card">
                                <div class="modal fade batal-bayar-modal" tabindex="-1" role="dialog"
                                    aria-labelledby="mytambah-modal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class=" modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myLargeModalLabel">Perhatian !</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-12">
                                                                <label for="formrow-nama-input" class="form-label">Yakin
                                                                    akan membatalkan validasi pembayaran</label>
                                                                ?</label>
                                                                <input type="hidden" class="form-control"
                                                                    id="confnoregis" name="norgis" placeholder=""
                                                                    value="" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button onclick="unvalidbayar()" class="btn btn-primary w-md">
                                                            Ya</button> <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Data Mahasiswa Belum Divalidasi</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table1 table-bordered"
                                                title='DATA MAHASISWA BELUM DIVALIDASI REGISTRASI'>
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No Registrasi</th>
                                                        <th>Nama Mahasiswa</th>
                                                        <th>Program Studi</th>
                                                        <th>No Hp</th>
                                                        <th>Bukti Pembayaran</th>
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
                                                            echo "<tr>
                                                                    <td>$i</td>
                                                                    <td for='noregis'>$row->no_peserta</td>
                                                                    <td>$row->nama</td>
                                                                    <td>$row->nama_prodi</td>
                                                                    <td>$row->nohape</td>
                                                                    <td><a href='" . base_url("uploads/berkas/$row->no_peserta/bb$row->no_peserta.pdf") . "' target='_blank'><button class='btn btn-sm btn-primary'>Bukti Bayar</button></a></td>
                                                                    <td><button class='btn btn-sm btn-primary' onclick='validasi($(this))'>Validasi</button></td>
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
                                            <table class="table table2 table-bordered "
                                                title='DATA MAHASISWA SUDAH DIVALIDASI REGISTRASI'>
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>No Registrasi</th>
                                                        <th>Nama Mahasiswa</th>
                                                        <th>Program Studi</th>
                                                        <th>No Hp</th>
                                                        <th>Bukti Pembayaran</th>
                                                        <th>Tagihan</th>
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

                                                            if ($row->valid == 1) {
                                                                $buttonvalid = "<button class='btn btn-sm mx-1 my-1 btn-success' onclick='confunvalidbayar($(this))'>Sudah Bayar</button>";
                                                            } else {
                                                                $buttonvalid = "<button class='btn btn-sm btn-danger mx-1 my-1' onclick='validbayar($(this))'>Belum Bayar</button>";
                                                            }
                                                            echo "<tr>
                                                                    <td>$i</td>
                                                                    <td for='noregis'>$row->no_peserta</td>
                                                                    <td>$row->nama</td>
                                                                    <td>$row->nama_prodi</td>
                                                                    <td>$row->nohape</td>
                                                                    <td><a href='" . base_url("uploads/berkas/$row->no_peserta/bb$row->no_peserta.pdf") . "' target='_blank'><button class='btn btn-sm btn-primary'>Bukti Bayar</button></a></td>
                                                                    <td ><a href='" . base_url("print-tagihan/$row->no_peserta") . "' target='_blank'><button class='btn btn-sm btn-primary'>Tagihan</button></a></td>
                                                                    <td class='text-center'><button class='btn btn-sm btn-primary' onclick='unvalidasi($(this))'>Unvalidasi</button>" . $buttonvalid . "</td>
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

        judul1 = $('.table1').attr('title')
        judul2 = $('.table2').attr('title')

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

    })

    function validasi(ini) {
        noregis = ini.parent().parent().find('td[for=noregis]').html()

        url = '<?= base_url('validasikeu') ?>'

        $.post(url, {
            noregis: noregis
        }, function(data) {
            let confirmAction = confirm(data);

            if (confirmAction) {
                location.reload();
            } else {
                location.reload();
            }
        })

    }

    function validbayar(ini) {
        noregis = ini.parent().parent().find('td[for=noregis]').html()

        url = '<?= base_url('validasibayar') ?>'

        $.post(url, {
            noregis: noregis
        }, function(data) {
            let confirmAction = confirm(data);

            if (confirmAction) {
                location.reload();
            } else {
                location.reload();
            }
        })

    }

    function confunvalidbayar(ini) {
        noregis = ini.parent().parent().find('td[for=noregis]').html()
        $('#confnoregis').val(noregis)
        $('.batal-bayar-modal').modal('show');
    }

    function unvalidbayar() {
        $('#loading').show()
        $('.batal-bayar-modal').modal('hide');
        noregis = $('#confnoregis').val()
        url = '<?= base_url('unvalidasibayar') ?>'

        $.post(url, {
            noregis: noregis
        }, function(data) {
            $('#loading').hide()

            let confirmAction = confirm(data);

            if (confirmAction) {
                location.reload();
            } else {
                location.reload();
            }
        })

    }

    function unvalidasi(ini) {
        noregis = ini.parent().parent().find('td[for=noregis]').html()

        url = '<?= base_url('unvalidasikeu') ?>'

        $.post(url, {
            noregis: noregis
        }, function(data) {
            let confirmAction = confirm(data);

            if (confirmAction) {
                location.reload();
            } else {
                location.reload();
            }
        })

    }
    </script>
</body>

</html>